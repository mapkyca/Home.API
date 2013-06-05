<?php

    require_once(dirname(__FILE__) . '/engine/start.php');
    
    echo home_io\templates\Template::getInstance()->outputPage("Hello World", "Hello World");