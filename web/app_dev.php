<?php
if (array_key_exists(ini_get('session.name'), $_GET)) {
    $_COOKIE[ini_get('session.name')] = $_GET[ini_get('session.name')];
}
// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it, or make something more sophisticated.
if (!in_array(@$_SERVER['REMOTE_ADDR'], array(
    '127.0.0.1',
    '::1',
    '64.115.170.232',
    '68.197.110.120',
))) {
//	if(!isset($_GET['token']) || (isset($_GET['token']) && ($_GET['token'] != "bootchamp"))) {
		header('HTTP/1.0 403 Forbidden');
		exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');		
//	}
}

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$kernel->handle(Request::createFromGlobals())->send();
