<?php

    if (!$vars['class']) $vars['class'] = "input-file";
	$vars['type'] = 'file';
	
    echo \home_api\templates\Template::v('input/input', $vars);