<?php

    if (Site::$config->debug) {
	
?>
<div class="object default debug">
    <pre>
<?php echo var_export($vars['object']); ?>
    </pre>
</div>
<?php	
    }