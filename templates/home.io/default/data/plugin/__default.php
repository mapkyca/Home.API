<?php

	$object = $vars['object'];
?>
<div id="plugin-for-<?=str_replace('/','-', $vars['call']); ?>" class="well plugin default">
    <h2><?=$vars['call'];?></h2>
    <?= \home_io\templates\Template::v('output/api', $vars); ?>
<?php 
if ((isset(home_io\Home::$config->debug)) && (home_io\Home::$config->debug)) { ?>
    <pre>
<?php echo var_export($vars['object']); ?>
    </pre>
<?php } ?>
</div>