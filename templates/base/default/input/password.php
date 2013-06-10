<?php

	if (!$vars['class']) $vars['class'] = "input-password";
	$vars['type'] = 'password';
		
	$vars['autocomplete'] = 'off';
	
	echo \home_api\templates\Template::v('input/input', $vars);
	 