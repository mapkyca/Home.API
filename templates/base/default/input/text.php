<?php

	if (!$vars['class']) $vars['class'] = "input-text";
	echo \home_api\templates\Template::v('input/input', $vars);
	 