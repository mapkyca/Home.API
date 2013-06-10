<?php

	if (!$vars['class']) $vars['class'] = "input-email";
	$vars['type'] = 'email';
	
	echo \home_api\templates\Template::v('input/input', $vars);
 