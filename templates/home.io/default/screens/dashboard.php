<?php

    $sidebar = home_io\templates\Template::v('screens/dashboard/sidebar');
    $content = home_io\templates\Template::v('screens/dashboard/dashboard');
    
    echo home_io\templates\Template::v('page/layouts/one_column_sidebar', array('sidebar' => $sidebar, 'content' => $content));