<?php
$object = $vars['object'];

?>
<div id="plugin-for-<?= str_replace('/', '-', $vars['call']); ?>" class="well plugin CurrentCostEnviR">
    <h2><?= $vars['call']; ?></h2>
    <div class="progress progress-striped active">
        <div class="bar" style="width: 100%;"></div>
    </div>
    <table class="table table-striped table-bordered" style="display: none;">
            
            <tr class="time">
                <td><b><?= home_api\i18n\i18n::w('currentcostenvir:time'); ?></b></td>
                <td class="reading"></td>
            </tr>
            
            <tr class="temp">
                <td><b><?= home_api\i18n\i18n::w('currentcostenvir:temp'); ?></b></td>
                <td class="reading"></td>
            </tr>
            <tr class="power">
                <td><b><?= home_api\i18n\i18n::w('currentcostenvir:power'); ?></b></td>
                <td class="reading"></td>
            </tr>
            
    </table>
</div>
<script>
    $(document).ready(function(){
        HomeAPI.call('<?=$vars['call'];?>/latest.json', {}, function(result) {
            HomeAPI.extractBody(result, function(data) {
                
                $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> div.progress').fadeOut();
                $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> table').fadeIn();
                
                // Get time
                if (data.time != null) {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.time').addClass('info');
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.time td.reading').html(data.time);
                }
                else {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.time').addClass('error');
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.time td.reading').html("<?=\home_api\i18n\i18n::w('currentcostenvir:exception:time_unavailable')?>");
                }
                
                // Temperature
                if (data.temp != null) {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.temp').addClass('info');
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.temp td.reading').html(data.temp + "C");
                }
                else {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.temp').addClass('error');
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.temp td.reading').html("<?=\home_api\i18n\i18n::w('currentcostenvir:exception:temp_unavailable')?>");
                }
                
                // Power
                if (data.power != null) {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.power').addClass('info');
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.power td.reading').html(data.power + " watts");
                }
                else {
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.power').addClass('error');
                    $('#plugin-for-<?= str_replace('/', '-', $vars['call']); ?> tr.power td.reading').html("<?=\home_api\i18n\i18n::w('currentcostenvir:exception:power_unavailable')?>");
                }
            });
        });
    });
</script>