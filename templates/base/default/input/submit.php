<?php
	
	$vars['type'] = 'submit';
	if (!$vars['class']) $vars['class'] = "input-submit";
		
	echo \home_io\templates\Template::v('input/button', $vars);
