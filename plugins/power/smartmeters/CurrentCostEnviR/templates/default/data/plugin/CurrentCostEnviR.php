<?php
$object = $vars['object'];
?>
<div id="plugin-for-<?= str_replace('/', '-', $vars['call']); ?>" class="well plugin CurrentCostEnviR">
    <h2><?= $vars['call']; ?></h2>
    <table class="table table-striped table-bordered">
            <tr>
                <td><?= home_api\i18n\i18n::w('currentcostenvir:time'); ?></td>
                <td><?=$object->time(); ?></td>
            </tr>
            <tr>
                <td><?= home_api\i18n\i18n::w('currentcostenvir:temp'); ?></td>
                <td><?= home_api\i18n\i18n::w('currentcostenvir:temp:reading', array($object->temp())); ?></td>
            </tr>
            <tr>
                <td><?= home_api\i18n\i18n::w('currentcostenvir:power'); ?></td>
                <td><?= home_api\i18n\i18n::w('currentcostenvir:power:reading', array($object->power())); ?></td>
            </tr>
            
    </table>
</div>