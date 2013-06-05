<?php

	// Define possible fields and their defaults, a boolean FALSE means don't show if not present
	$fields_and_defaults = array(
		'name' => false,
		'id'   => false,
		'autofocus' => false,
		'disabled' => false,
		'readonly' => false,
		'required' => false,
		'rows' => false,
		'wrap' => 'soft',
	
		'onclick' => false,
		'onfocus' => false,
		'onblur' => false,
	);

	$class = $vars['class'];
	if (!$class) $class = "input-longtext";
	
	// We always want a unique ID
	static $input_id;
	if (!$vars['id']) {
		$input_id ++;
		$vars['id'] = $vars['name'] . "_$input_id";
	}
?>
<textarea 
	<?php
		foreach ($fields_and_defaults as $field => $default)
		{
			if (isset($vars[$field]))
				echo "$field=\"{$vars[$field]}\" ";
			else
			{
				if ($default!==false)
					echo "$field=\"$default\" ";
			}
	}
	?>
	class="input <?php echo $class; ?>"
	<?php if (isset($vars['placeholder'])) { ?>placeholder="<?php echo htmlentities($vars['placeholder'], ENT_QUOTES, 'UTF-8'); ?>" <?php } // Placeholder is a special case ?>
><?php echo htmlentities($vars['value'], ENT_QUOTES, 'UTF-8'); ?></textarea> 