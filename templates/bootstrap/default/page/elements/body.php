<body>
	<?php echo \home_api\templates\Template::v('page/elements/messages'); ?>
	
		    <?php echo \home_api\templates\Template::v('page/elements/pagetop', $vars); ?>

        <div id="content">
            <div class="container">	
                <?php echo $vars['body']; ?>
            </div>
        </div>
		    <?php echo \home_api\templates\Template::v('page/elements/pagebottom', $vars); ?>
	
    
        <?php echo \home_api\templates\Template::v('page/elements/footer', $vars); ?>
</body>