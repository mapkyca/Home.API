<?php
	$vars['type'] = 'reset';
	if (!$vars['class']) $vars['class'] = "input-reset";
		
	echo \home_api\templates\Template::v('input/button', $vars);
