<?php

	$object = $vars['object'];
        
        $error = null;
        $athome = false;
        try {
            $name = $object->getName();
            $athome = $object->athome();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
?>
<div id="plugin-for-<?=str_replace('/','-', $vars['call']); ?>" class="well plugin arpping">
    <h2><?=$vars['call'];?></h2>
    <?php
    if ($error) {
        ?>
    <div class="alert alert-error"><?=$error;?></div>
    <?php
    } else {
        
        if ($athome)
        {
            ?>
    <div class="alert alert-success"><?= home_api\i18n\i18n::w('arpping:at_home', array($name)); ?></div>
    <?php
        }
        else
        {
            ?>
    <div class="alert"><?= home_api\i18n\i18n::w('arpping:not_at_home', array($name)); ?></div>
    <?php
        }
    } ?>
</div>