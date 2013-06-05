<body>
	<?php echo \home_io\templates\Template::v('page/elements/messages'); ?>
	
		    <?php echo \home_io\templates\Template::v('page/elements/pagetop', $vars); ?>
		    <?php
        if ($vars['no_container_wrap'])
            echo $vars['body'];
        else
        {
            ?>
        <div id="content">
            <div class="container">	
                <?php echo $vars['body']; ?>
            </div>
        </div>
        <?php } ?>
		    <?php echo \home_io\templates\Template::v('page/elements/pagebottom', $vars); ?>
	
    
        <?php echo \home_io\templates\Template::v('page/elements/footer', $vars); ?>
</body>