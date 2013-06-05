@CHARSET "UTF-8";


<?php

    // Load various CSS components

    foreach (array(
	'home.io',
    ) as $css)
    {
	?>

	/** BEGIN: <?php echo $css; ?> */
	
	<?php echo \home_io\templates\Template::v("css/$css", $vars); ?>
	
	/** END:  <?php echo $css; ?> */
	
	<?php
	
    }

?>