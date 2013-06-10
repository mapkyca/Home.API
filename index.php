<?php

    require_once(dirname(__FILE__) . '/engine/start.php');
    
    $api = home_api\api\API::get();
    if ((!$api) || (count($api) == 0))
    {    
        $content = home_api\templates\Template::getInstance()->screen('welcome');
    }
    else
    {
        $title = home_api\i18n\i18n::w('home_api:dashboard');
        $content = home_api\templates\Template::getInstance()->screen('dashboard');
    }
    
    
    
    echo home_api\templates\Template::getInstance()->outputPage($title, $content);