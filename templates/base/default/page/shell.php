<?php
/**
 * @file
 * Site page shell.
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */
header("Content-type: text/html; charset=UTF-8");
?><!DOCTYPE html>
<html>
<?php echo \home_api\templates\Template::v('page/elements/header', $vars); ?>
<?php echo \home_api\templates\Template::v('page/elements/body', $vars); ?>
</html>