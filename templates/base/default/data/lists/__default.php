<?php

    $objects = $vars['objects'];
?>
<div class="list default">
    <?php if (($vars['pagination']) && ($vars['total']))
	echo \home_api\templates\Template::v('data/lists/elements/pagination', $vars);?>
    <ul>
    <?php 
	if (is_array($objects))
	{
	    $vars['list'] = true;
	    $cnt = 0;
	    
	    foreach ($objects as $object) {	
?>
        <li class="<?php echo strtolower(get_class($object)); ?>">
	    <?php if (is_callable(array($object, 'view'))) 
		echo $object->view($vars); ?>
	</li>
<?php
	    }
	}
    ?>
    </ul>
</div>
