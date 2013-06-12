<?php
$object = $vars['object'];

$details = array();

$details['time_ok'] = true;
$details['temp_ok'] = true;
$details['power_ok'] = true;

try {
    $details['time_value'] = $object->time();
} catch (Exception $e) {
    $details['time_ok'] = false;
    $details['time_value'] = $e->getMessage();
}

try {
    $details['temp_value'] = home_api\i18n\i18n::w('currentcostenvir:temp:reading', array($object->temp()));
} catch (Exception $e) {
    $details['temp_ok'] = false;
    $details['temp_value'] = $e->getMessage();
}

try {
    $details['power_value'] = home_api\i18n\i18n::w('currentcostenvir:power:reading', array($object->power()));
} catch (Exception $e) {
    $details['power_ok'] = false;
    $details['power_value'] = $e->getMessage();
}

?>
<div id="plugin-for-<?= str_replace('/', '-', $vars['call']); ?>" class="well plugin CurrentCostEnviR">
    <h2><?= $vars['call']; ?></h2>
    <table class="table table-striped table-bordered">
            
            <tr class="<?= $details['time_ok'] ? 'success' : 'error'; ?>">
                <td><b><?= home_api\i18n\i18n::w('currentcostenvir:time'); ?></b></td>
                <td><?= $details['time_value'];?></td>
            </tr>
            
            <tr class="<?= $details['temp_ok'] ? 'success' : 'error'; ?>">
                <td><b><?= home_api\i18n\i18n::w('currentcostenvir:temp'); ?></b></td>
                <td><?= $details['temp_value'];?></td>
            </tr>
            <tr class="<?= $details['power_ok'] ? 'success' : 'error'; ?>">
                <td><b><?= home_api\i18n\i18n::w('currentcostenvir:power'); ?></b></td>
                <td><?= $details['power_value'];?></td>
            </tr>
            
    </table>
</div>