<?php

/**
 * @file
 * 
 * See if a given mac address is on the network.
 * 
 * Check to see if a user's device is on the network, and by extension see if they're at home. 
 * Typical usecase is to see if a person's smartphone is on the wifi, and by extension, at home.
 * 
 * @package people
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace people {

    // Use some Home.API classes
    use home_api\core\Log as Log;
    
    /**
     * Ping a user's device, to see if they're on the network.
     */
    class ARPPing extends \home_api\plugins\Plugin {
        
        private $mac;
        private $name;
        private $arp;
        
        public function __construct($mac, $name, $arp = '/proc/net/arp') {
            $this->mac = strtolower($mac);
            $this->name = $name;
            $this->arp = $arp;
        }
        
        public function getName() { return $this->name; }
        
        public function athome() {

            $return = new \stdClass();
            $return->name = $this->name;
            
            ob_start();
                passthru("cat " . escapeshellcmd("/proc/net/arp"));
            $result = ob_get_clean();

            // See if we have an arp entry
            if (preg_match("/{$this->mac}/", strtolower($result)))
            {
                // Yes, so try and ping it to make sure.
                system('ping -c 1 -W 5 `cat /proc/net/arp | grep "'.escapeshellcmd($this->mac).'" | cut -d" " -f 1` >/dev/null', $val); // Depending on your network this may or may not be too reliable... TODO: Make it less flipfloppy
                if ($val == 0) 
                    $return->athome = true;
                
            }
                
            $return->athome = false;
            return $return;
            
        }
        
        public function expose() {
            return array('athome');
        }        
    }
    
}
