
<?php

    if (empty($vars['noheader'])) {

        echo \home_io\templates\Template::v('page/elements/topnav', $vars);
?>
<div id="header">
    <div class="container">  
        <div class="row">
            <div class="span12">
                <h1><?php echo $vars['title']; ?></h1>
            </div>
        </div>
    </div>
</div>
<?php

    }

?>