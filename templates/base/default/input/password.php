<?php

	if (!$vars['class']) $vars['class'] = "input-password";
	$vars['type'] = 'password';
		
	$vars['autocomplete'] = 'off';
	
	echo \home_io\templates\Template::v('input/input', $vars);
	 