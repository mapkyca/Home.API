<?php
    $api = \home_io\api\API::get();
    
    ksort($api);
    
    foreach ($api as $call => $definition) {
        ?>
        <a id="<?=str_replace('/','-',$call) ?>"></a>
        <?php
        try {
            if ($plugin = home_io\plugins\Plugin::getInstance($definition))
                    echo $plugin->view();
        } catch (\home_io\plugins\PluginException $e) {
            ?>
<div class="alert alert-error">
    <h1><?=$call; ?></h1>
    <?=$e->getMessage();?>
</div>
            <?php
        }
    }
    
