<?php
	
	$ts = time();
	$token = Action::getToken($ts);
	
	echo \home_io\templates\Template::v('input/hidden', array('name' => '__to', 'value' => $token));
	echo \home_io\templates\Template::v('input/hidden', array('name' => '__ts', 'value' => $ts));
