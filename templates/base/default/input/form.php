<?php
	
	// Define possible fields and their defaults, a boolean FALSE means don't show if not present
	$fields_and_defaults = array(
	    'name' => false,
	    'id'   => false,

	    'method' => 'POST',
	    'enctype' => false,
	    'novalidate' => false,

	    'onsubmit' => false,

	);
	
	global $form_id;
	if (!$vars['id']) {
		$form_id ++;
		$vars['id'] = $vars['name'] . "$form_id";
	}
?>
<form <?php
		foreach ($fields_and_defaults as $field => $default)
		{
			if (isset($vars[$field]))
			{
				if ($vars[$field]===true)
					echo "$field ";
				else
					echo "$field=\"{$vars[$field]}\" ";
			}
			else
			{
				if ($default!==false)
				{
					if ($default===true)
						echo "$field ";
					else
						echo "$field=\"$default\" ";		
				}
			}
		}
	?>
	<?php
	if (!$vars['ajax']) {
	    // Handle action
	    if (
		    (strpos($vars['action'], 'http://')!==false) ||
		    (strpos($vars['action'], 'https://')!==false)
	    )
	    {
		// Full URL specified, no further processing done
		echo "action=\"{$vars['action']}\" ";
	    }
	    else
	    {
		$action = $vars['CONFIG']->wwwroot.'action/'.$vars['action'];
		if ($vars['https'])
		    $action = str_replace ('http://', 'https://', $action);
		echo "action=\"$action\" ";
	    }
	}
	?>
	>
	<?php echo \home_api\templates\Template::v('input/securitytoken'); ?>
	<?php echo $vars['body']; ?>
</form>