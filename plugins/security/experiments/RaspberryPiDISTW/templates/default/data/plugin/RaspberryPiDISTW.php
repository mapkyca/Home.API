<?php
$object = $vars['object'];

$status = $object->getAll();

?>
<div id="plugin-for-<?= str_replace('/', '-', $vars['call']); ?>" class="well plugin RaspberryPiDISTW">
    <h2><?= $vars['call']; ?></h2>
    <table class="table table-striped table-bordered">
            
        <?php foreach ($status as $label => $stat) { ?>
            <tr class="<?= $stat == 'closed' ? 'success' : 'error'; ?>">
                <td><b><?= $label ?></b></td>
                <td><?= $stat?></td>
            </tr>
        <?php } ?>
            
    </table>
</div>