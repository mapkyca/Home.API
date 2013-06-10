<?php

    $objects = $vars['feed'];
?>
<div class="activity-list list default">
    <?php if (($vars['pagination']) && ($vars['total']))
	echo \home_api\templates\Template::v('data/lists/elements/pagination', $vars);?>
    <ul>
    <?php 
	if (is_array($objects))
	{
	    $vars['list'] = true;
	    $cnt = 0;
	    
	    foreach ($objects as $f) {	
                $class = strtolower($f->context_class);
                $verb = strtolower($f->verb);
?>
        <li id="activity-item-<?=$f->id;?>" class="activity <?= $class; ?> <?= $verb; ?>">
            <?php  
                if (\home_api\templates\Template::getInstance()->viewExists("activity/event/$class/$verb"))
                    echo \home_api\templates\Template::v("activity/event/$class/$verb", $vars + array('activity' => $f));
                elseif (\home_api\templates\Template::getInstance()->viewExists("activity/event/$class/__default"))
                    echo \home_api\templates\Template::v("activity/event/$class/__default", $vars + array('activity' => $f));
                elseif (\home_api\templates\Template::getInstance()->viewExists("activity/event/__default"))
                    echo \home_api\templates\Template::v("activity/event/__default", $vars + array('activity' => $f));
            ?>
	</li>
<?php
	    }
	}
    ?>
    </ul>
</div>
