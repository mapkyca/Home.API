<?php

/**
 * @file
 * 
 * Handler for virtual pages.
 * 
 * Virtual pages are pages which don't physically exist, rather they are 
 * provided virtually and dynamically by classes and library functions in
 * the engine.
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */
require_once(dirname(dirname(__FILE__)) . '/start.php');

$page = \home_io\core\Input::get('page');

header("X-Handler: home.io page handler");

if (!Page::call($page)) {
    \home_io\core\Page::set404();

    throw new \home_io\core\exceptions\PageNotFoundException(sprintf(\home_io\core\i18n::w('page:exception:notfound'), $page));
}