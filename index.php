<?php

    require_once(dirname(__FILE__) . '/engine/start.php');
    
    $content = home_io\templates\Template::getInstance()->screen('dashboard');
    echo home_io\templates\Template::getInstance()->outputPage($vars['title'], $content);