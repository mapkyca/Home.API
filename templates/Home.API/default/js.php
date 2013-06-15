<?php

    // Load various CSS components

    foreach (array(
	'environment',
	'api',
    ) as $js)
    {
	?>

	/** BEGIN: <?php echo $js; ?> */
	
	<?php echo \home_api\templates\Template::v("js/$js", $vars); ?>
	
	/** END:  <?php echo $js; ?> */
	
	<?php
	
    }

?>