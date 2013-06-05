<?php
	global $CONFIG;
	
	$exception = $vars['exception'];
	$class = get_class($exception);
	$class_lower = strtolower($class);
	$message = $exception->getMessage();
?>
<div class="exception">
	<div class="<?php echo $class_lower; ?>">
		<p><?php echo $message; ?></p>
	</div>

<?php 
	if ($CONFIG->debug) {
?>
    <h2>Debug output (only visible when $CONFIG->debug=true;)</h2>
	<div class="debug">
<pre>
<?php print_r($exception); ?>
</pre>
	</div>
    
	<strong>This is the default error handler. To handle this message nicely, please create a default/exceptions/<?php echo $class_lower; ?> template.</strong>
<?php		
	}
?>
</div>
