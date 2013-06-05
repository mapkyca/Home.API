<?php

	if (!$vars['class']) $vars['class'] = "input-email";
	$vars['type'] = 'email';
	
	echo \home_io\templates\Template::v('input/input', $vars);
 