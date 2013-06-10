<?php
    $api = \home_api\api\API::get();
    
    ksort($api);
    
    foreach ($api as $call => $definition) {
        ?>
        <a id="<?=str_replace('/','-',$call) ?>"></a>
        <?php
        try {
            if ($plugin = home_api\plugins\Plugin::getInstance($definition))
                    echo $plugin->view(array('call' => $call));
        } catch (\home_api\plugins\PluginException $e) {
            ?>
<div class="alert alert-error">
    <h1><?=$call; ?></h1>
    <?=$e->getMessage();?>
</div>
            <?php
        }
    }
    
?>

<script>
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    
    $(document).ready(function(){
        $('form.api-call').submit(function(){
            
            var self = this;
            
            $.ajax({  
                type: "GET",  
                url: $(this).attr('action'),
                data: $(this).serialize(),  
                dataType: "json",  

                success: function(msg, status, jqXHR){  
                    var id = $(self).attr('id'); 
                    $('#' + id + ' div.result').html("<pre class=\"alert alert-success\">" + jqXHR.responseText + "</pre>");
                    $('#' + id + ' div.result').fadeIn();
                },  
                error: function(){  
                    var id = $(this).attr('id');
                    $('#' + id + ' div.result').html("<pre class=\"alert alert-error\">There was a problem submitting this API call.</pre>");
                    $('#' + id + ' div.result').fadeIn();
                }  
            });  
            
            return false;
        });
        
        $('form.api-call a.submit').click(function(){
            
            $(this).parent('form').submit();
            
            return false;
        });
    });
</script>