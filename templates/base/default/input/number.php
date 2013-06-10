<?php
	/**
	 * Numeric input field.
	 * 
	 * @package core
	 * @license The MIT License (see LICENCE.txt), other licenses available.
	 * @author Marcus Povey <marcus@marcus-povey.co.uk>
	 * @copyright Marcus Povey 2009-2012
	 * @link http://platform.barcamptransparency.org/
	 */

	if (!$vars['class']) $vars['class'] = "input-number";
	$vars['type'] = 'number';
		
	if (!is_numeric($vars['value']))
		$vars['value'] = (int)$vars['value'];
	
	echo \home_api\templates\Template::v('input/input', $vars);
	