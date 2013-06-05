<?php

	if (!$vars['class']) $vars['class'] = "input-url";
	$vars['type'] = 'url';
	
	echo \home_io\templates\Template::v('input/input', $vars);
 