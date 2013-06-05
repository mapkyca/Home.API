<?php

	if (!$vars['class']) $vars['class'] = "input-text";
	echo \home_io\templates\Template::v('input/input', $vars);
	 