<?php
	
	$ts = time();
	$token = Action::getToken($ts);
	
	echo \home_api\templates\Template::v('input/hidden', array('name' => '__to', 'value' => $token));
	echo \home_api\templates\Template::v('input/hidden', array('name' => '__ts', 'value' => $ts));
