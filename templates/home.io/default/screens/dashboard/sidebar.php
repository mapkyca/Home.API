<?php
    $api = \home_io\api\API::get();
    
    ksort($api);
    
?>
<ul class="nav nav-tabs nav-stacked">
    <li class="nav-header"><?=\home_io\i18n\i18n::w("home_io:dashboard");?></li>
  <li><a href="#"><?=\home_io\i18n\i18n::w("home_io:top");?></a></li>
  <?php
    foreach ($api as $endpoint => $definition)
    {
        ?>
  <li><a href="#<?=str_replace('/','-',$endpoint);?>"><?=$endpoint;?></a></li>
        <?php
    }
  ?>
  
  
</ul>