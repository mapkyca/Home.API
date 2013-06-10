<?php
    $method = $vars['method'];
    $parameters = $method->getParameters();
?>
<form id="<?=$vars['id'];?>" class="api-call form-inline" action="<?=\home_io\core\Environment::getWebRoot();?>api/<?=$vars['call'];?>/<?=$method->getName();?>.json"> 
    <?=$method->getName(); ?> ( 

    <?php
    $form = "";
    foreach ($parameters as $param)
    {
        $form .= \home_io\templates\Template::v('input/text', array('class' => 'input-small', 'name' => $param->getName(), 'placeholder' => $param->getName(), 'value' => $param->isOptional() ? $param->getDefaultValue() : ''));
           
    }
    echo trim($form, ', ');
    
    ?> ) <a class="submit btn btn-small" href="#">Call...</a>
    <div class="result" style="display:none;">
        
    </div>
</form>
