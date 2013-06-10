<?php

    require_once(dirname(__FILE__) . '/engine/start.php');
    
    $api = home_io\api\API::get();
    if ((!$api) || (count($api) == 0))
    {    
        $content = home_io\templates\Template::getInstance()->screen('welcome');
 
    }
    else
    {
        $title = home_io\i18n\i18n::w('home_io:dashboard');
        $content = home_io\templates\Template::getInstance()->screen('dashboard');
    }
    
    
    
    echo home_io\templates\Template::getInstance()->outputPage($title, $content);