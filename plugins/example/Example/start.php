<?php


namespace example {
    
    class Example extends \home_io\plugins\Plugin {
        
        private $param1;
        private $param2;
        
        public function __construct($param1, $param2) {
            $this->param1 = $param1;
            $this->param2 = $param2;
        }
        
        public function echoparams() {
            return "Entered: Param1 = {$this->param1}, Param2 = {$this->param2}";
        }
        
        public function asarray() {
            return array(
                'param1' => $this->param1,
                'param2' => $this->param2
            );
        }
        
        public function sayhello($to = 'you') {
            return "Hello $to!";
        }
    }
    
}
