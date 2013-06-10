<?php

    $sidebar = home_api\templates\Template::v('screens/dashboard/sidebar');
    $content = home_api\templates\Template::v('screens/dashboard/dashboard');
    
    echo home_api\templates\Template::v('page/layouts/one_column_sidebar', array('sidebar' => $sidebar, 'content' => $content));