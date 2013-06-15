<?php

	$object = $vars['object'];
        
   /*     $error = null;
        $athome = false;
        try {
            $name = $object->getName();
            $athome = $object->athome();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }*/
?>
<div id="plugin-for-<?=str_replace('/','-', $vars['call']); ?>" class="well plugin arpping">
    <h2><?=$vars['call'];?></h2>
    <div class="progress progress-striped active">
        <div class="bar" style="width: 100%;"></div>
    </div>
    <div class="alert" style="display:none;"></div>
</div>

<script>
    $(document).ready(function(){
        HomeAPI.call('<?=$vars['call'];?>/athome.json', {}, function(result) {
            HomeAPI.extractBody(result, function(data) {
                
                $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> div.progress').fadeOut();
                $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> div.alert').fadeIn();
    
                if (data.athome) {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> div.alert').addClass('alert-success');
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> div.alert').html(data.name + " <?=home_api\i18n\i18n::w('arpping:at_home'); ?>");
                } else {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> div.alert').html(data.name + " <?=home_api\i18n\i18n::w('arpping:not_at_home'); ?>");
                }
                
            });
        });
    });
</script>