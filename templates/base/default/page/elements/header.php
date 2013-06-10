<?php
	global $version, $release;
?>
<head>
	<meta charset="utf-8" />
	<title><?php
		if (!empty($vars['title'])) { 
			echo $vars['title']; 
                        if (isset(\home_api\Home::$config->name)) ' | ';
		}
		if (isset(\home_api\Home::$config->name)) echo \home_api\Home::$config->name;
	?></title>
	<link rel="stylesheet" href="<?php echo \home_api\core\Environment::getWebRoot(); ?>style.<?=$version; ?>.css" />
	<link type="text/plain" rel="author" href="<?php echo \home_api\core\Environment::getWebRoot(); ?>humans.txt" />
	<script type="text/javascript" src="<?php echo \home_api\core\Environment::getWebRoot(); ?>script.<?=$version; ?>.js" /></script>
	
	<?php echo \home_api\templates\Template::v('metatags', $vars); ?>
	<?php echo \home_api\templates\Template::v('favicon', $vars); ?>
    
</head>