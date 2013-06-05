<body>
	<?php echo \home_io\templates\Template::v('page/elements/messages'); ?>
	<div id="container">
	    <div id="mainShell">
		<div id="contentShell">
		    <header><?php echo \home_io\templates\Template::v('page/elements/pagetop', $vars); ?></header>
		    <section>
			    <div id="pageContent">
				    <?php echo $vars['body']; ?>
			    </div>
		    </section>
		    <footer><?php echo \home_io\templates\Template::v('page/elements/pagebottom', $vars); ?></footer>
		</div>
	    </div>
	</div>
    
        <?php echo \home_io\templates\Template::v('page/elements/footer', $vars); ?>
</body>