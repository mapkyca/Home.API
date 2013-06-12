<?php

/**
 * @file
 * 
 * Current Cost EnviR smart meter driver for Home.API.
 * 
 * This class requires that the smart meter be connected to the machine running Home.API and that the serial port it is connected to is 
 * accessible by your Home.API user
 * 
 * @package power/smartmeters
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace power\smartmeters {

    // Use some Home.API classes
    use home_api\core\Log as Log;
    
    /**
     * Current class envir
     */
    class CurrentCostEnviR extends \home_api\plugins\Plugin {
        
        private $port;
        private $baud;
        private $timeout;
                
        private $readData;
        
        public function __construct($port = '/dev/ttyUSB0', $baud = 57600, $timeout = 10) {
            $this->port = $port;
            $this->baud = $baud;
            $this->timeout = microtime(true) + $timeout;
        }
        
        protected function readline() {
            
            Log::debug("Reading a line from serial port ({$this->port}:{$this->baud}).");
            
            exec("/bin/stty -F {$this->port} {$this->baud} sane raw cs8 hupcl cread clocal -echo -onlcr ");
            
            $fp=fopen("{$this->port}","c+");
            if(!$fp) throw new \home_api\plugins\PluginException(\home_api\i18n\i18n::w('currentcostenvir:exception:cant_open_device', array($this->port, $this->baud)));
            
            stream_set_blocking($fp,0);
            do{
              // Try to read one character from the device
              $c=fgetc($fp);

              // Wait for data to arive 
              if($c === false){
                  usleep(50000);
                  continue;
              }  

              $data.=$c;

            } while( (($c!="\n") && ($c!="\r"))  && microtime(true)<$this->timeout); 
            
            Log::debug("Read $data");
            
            // Parse data
            preg_match('/<watts>([0-9]+)<\/watts>/', $data, $matches); $this->readData['power'] = $matches[1];
            preg_match('/<time>([0-9\.\:]+)<\/time>/', $data, $matches); $this->readData['time'] = $matches[1];
            preg_match('/<tmpr>([0-9\.]+)<\/tmpr>/', $data, $matches); $this->readData['temp'] = $matches[1];
        }

        public function time() {
            if (!isset($this->readData))
                $this->readline ();
            
            if (!isset($this->readData['time']))
                throw new \home_api\plugins\PluginException(\home_api\i18n\i18n::w('currentcostenvir:exception:time_unavailable'));
            
            return $this->readData['time'];
        }
        
        public function temp() {
            if (!isset($this->readData))
                $this->readline ();
            
            if (!isset($this->readData['temp']))
                throw new \home_api\plugins\PluginException(\home_api\i18n\i18n::w('currentcostenvir:exception:temp_unavailable'));
            
            return $this->readData['temp'];
        }
        
        public function power() {
            if (!isset($this->readData))
                $this->readline ();
            
            if (!isset($this->readData['power']))
                throw new \home_api\plugins\PluginException(\home_api\i18n\i18n::w('currentcostenvir:exception:power_unavailable'));
            
            return (int)$this->readData['power'];
        }
        
        public function expose() {
            return array('time', 'temp', 'power');
        }        
    }
    
}
