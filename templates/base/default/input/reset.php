<?php
	$vars['type'] = 'reset';
	if (!$vars['class']) $vars['class'] = "input-reset";
		
	echo \home_io\templates\Template::v('input/button', $vars);
