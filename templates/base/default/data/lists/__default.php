<?php

    $objects = $vars['objects'];
?>
<div class="list default">
    <?php if (($vars['pagination']) && ($vars['total']))
	echo \home_io\templates\Template::v('data/lists/elements/pagination', $vars);?>
    <ul>
    <?php 
	if (is_array($objects))
	{
	    $vars['list'] = true;
	    $cnt = 0;
	    
	    foreach ($objects as $object) {	
?>
        <li <?php if ($object instanceof DataObject) {?>id="list-item-<?=$object->id;?>"<?php }?> class="<?php echo strtolower(get_class($object)); ?>">
	    <?php if ($object instanceof DataObject) 
		echo $object->view($vars); ?>
	</li>
<?php
	    }
	}
    ?>
    </ul>
</div>
