<?php

    if (!$vars['class']) $vars['class'] = "input-file";
	$vars['type'] = 'file';
	
    echo \home_io\templates\Template::v('input/input', $vars);