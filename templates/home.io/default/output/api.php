<?php
    $callstub = str_replace('/','-', $vars['call']); 
    
    $mirror = new \ReflectionClass($vars['object']);
    
    $methods = $mirror->getMethods();
    
    if ($methods) {
        ?>
        
<div class="accordion" id="api-list-<?=$callstub ?>">
<?php
        
        foreach($methods as $method) {
            if (in_array($method->getName(), $vars['object']->expose())) {
                $parameters = $method->getParameters();
            
?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="api-list-<?=$callstub; ?>" href="#<?=md5($callstub.$method->getName());?>">
            <?=$method->getName(); ?>
              ( <?php
                $str = "";
                foreach ($parameters as $param)
                {
                    $str .= $param->getName();
                    if ($param->isOptional())
                        $str .= " = " . $param->getDefaultValue();
                    $str .=', ';
                }
                echo trim($str, ', ');
            ?> )
          </a> 
        </div>
        <div id="<?=md5($callstub.$method->getName());?>" class="accordion-body collapse">
          <div class="accordion-inner api-call">
              <?= \home_io\templates\Template::v('input/apicall', array('id' => 'call-'.md5($callstub.$method->getName()), 'call' => $vars['call'], 'method' => $method)); ?>
          </div>
        </div>
      </div>
<?php            
            }
        }
?>
</div>
<?php
        
    }
    ?>
