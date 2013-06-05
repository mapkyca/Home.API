<?php
	
	$form = $vars['fields'];
	$values = $vars['values'];
	
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
			else
				$value = $values->$field;
			
			if ($value) {
				?>
				<p class="<?php echo (++$n % 2 == 1) ? 'odd' : 'even'; ?> <?php echo $field; ?>"><label class="<?php echo $field; ?>"><?php echo _echo("formbody:output:$name:$field");?></label> <?php echo view("output/$type", array('value' => $value)); ?></p>
				<?php 		
			}
		}
	}