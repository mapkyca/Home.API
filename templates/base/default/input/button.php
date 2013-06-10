<?php

	if (!$vars['class']) $vars['class'] = "input-submit";
	if (!$vars['type']) $vars['type'] = 'submit';
	
	// Sanity check
	unset($vars['autofocus']);
	unset($vars['autocomplete']);
	
	echo \home_api\templates\Template::v('input/input', $vars);
 