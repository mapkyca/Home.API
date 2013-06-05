<?php

    global $__MENU_ID;

    $id = $vars['id'];
    if (!$id) $id='menu'.++$__MENU_ID;

    ?>
<div id="<?php echo $id; ?>" class="menu <?php echo $vars['class']; ?>">
    <ul>
	<?php
	    foreach ($vars['menu'] as $label => $url) {
	?>
	<li id="<?php echo "$id-$label"; ?>" class="<?php echo $label; ?> <?php if (Site::currentUrl() == $url) echo 'selected'; ?>">
	    <a id="<?php echo "$id-$label-link"; ?>" href="<?php echo $url;?>" title="<?php echo i18n::w("menu:$label");?>"><?php echo i18n::w("menu:$label"); ?></a>
	</li>
	<?php	
	    }
	?>
    </ul>
</div>