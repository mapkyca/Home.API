<?php
    $api = \home_api\api\API::get();
    
    ksort($api);
    
?>
<ul class="nav nav-tabs nav-stacked">
   <li><a href="#"><?=\home_api\i18n\i18n::w("home_api:top");?></a></li>
  <?php
    foreach ($api as $endpoint => $definition)
    {
        ?>
  <li><a href="#<?=str_replace('/','-',$endpoint);?>"><?=$endpoint;?></a></li>
        <?php
    }
  ?>
  
  
</ul>