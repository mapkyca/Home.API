<?php
	/**
	 * This input value provides a simple way of constructing forms
	 * simply without the need for a lot of typing.
	 * 
	 * It uses an associative array of 'field' => 'input_view' called $vars['fields']
	 * 
	 * Default values are in an array called $vars['values'] which can be an associative array
	 * 'field' => 'value', or an object.
	 * 
	 * Labels are "formbody:{$vars['name']}:$field", placeholders are "formbody:$name:$field:placeholder" language strings.
	 */


	$form = $vars['fields'];
	$values = $vars['values'];
	$required = $vars['required_fields'];
	$defaults = $vars['defaults'];
	
	
	$name = $vars['name'];
	if (!$name) $name = $vars['id'];
	if (!$name) $name = 'label';
	
	if ($form)
	{
		foreach ($form as $field => $type)
		{
			$value = "";
			if (is_array($values))
				$value = $values[$field];
			else if ($values instanceof DataObject)
				$value = $values->getField($field);
			else
				$value = $values->$field;

			if ((!$value) && (isset($defaults[$field])))
			    $value = $defaults[$field];
				
			$params = array('name' => $field, 'value' => $value, 'id' => "{$name}_{$field}");
			if ((i18n::getInstance()->translationExists("formbody:$name:$field:placeholder")) || ($vars['CONFIG']->debug))
			    $params['placeholder'] = i18n::w("formbody:$name:$field:placeholder");
			if (($vars['required_fields']) && (in_array($field, $vars['required_fields']))) 
				$params['required'] = true;

			if ($type != 'hidden') {
			?>
			<p class="<?php echo (++$n % 2 == 1) ? 'odd' : 'even'; ?> <?php echo $field; ?>"><label class="<?php echo $field; ?>"><?php echo i18n::w("formbody:$name:$field");?> <?php echo \home_api\templates\Template::v("input/$type", $params); ?></label></p>
			<?php
			} else
			    echo \home_api\templates\Template::v("input/$type", $params);
		}
		
		if ($values instanceof DataObject)
		    echo \home_api\templates\Template::v('input/hidden', array('name' => 'object_id', 'value' => $values->getId()));
		
	}