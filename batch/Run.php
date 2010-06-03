<?php

/**
 * @desc bootstrap for cli mode
 * @example php Run.php -a cli.relance.youtube -w 1
 * @example php Run.php -a cli.relance.semaine -w 3
 * it can be "Run.php -a cli.relance.semaine -w 3" too if execution rights are given to Run.php
 */

date_default_timezone_set('Asia/Shanghai');
$path = pathinfo(__FILE__, PATHINFO_DIRNAME);
$explodedPath = explode('/', $path);
array_pop($explodedPath);
$realpath = implode('/', $explodedPath);
//define('APPLICATION_PATH', $realpath . '/application');
// define('APPLICATION_PATH', '/data/www/Preview/Evian_BabiesCoaches/application');
define('APPLICATION_PATH', ' D:\training\application');
// define('APPLICATION_PATH', $realpath . '/application');

set_include_path(implode(PATH_SEPARATOR, array($realpath . '/library', get_include_path())));
set_include_path(APPLICATION_PATH . '/modules/cli/models' . PATH_SEPARATOR . get_include_path());

require_once ('Zend/Loader/Autoloader.php');
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace(array('Enterprise_'));

try {
	$opts = new Zend_Console_Getopt(array('help|h' => 'Displays usage information.', 'action|a=s' => 'Action to perform in format of module.controller.action', 'verbose|v' => 'Verbose messages will be dumped to the default output.', 'development|d' => 'Enables development mode.', 'week|w=d' => 'the week to send'));
	$opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
	exit($e->getMessage() . "\n\n" . $e->getUsageMessage());
}

if(isset($opts->h)) {
	echo $opts->getUsageMessage();
	exit();
}

if(isset($opts->a) && isset($opts->w)) {
	# init config
	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/cli.ini', 'tmp');
	$registry = Zend_Registry::getInstance();
	$registry->set('config', $config);
	$registry->set('week', $opts->w);

	# init db
	$db = Zend_Db::factory($config->resources->db);
	$db->getConnection();
	$db->query("SET NAMES 'utf8'");
	$db->setFetchMode(Zend_Db::FETCH_OBJ);
	$registry->set('db', $db);

	$reqRoute = array_reverse(explode('.', $opts->a));
	@list($action, $controller, $module) = $reqRoute;
	$request = new Zend_Controller_Request_Simple($action, $controller, $module);

	$controllerDirectory = APPLICATION_PATH . '/modules/' . $module . '/controllers';

	# init front controller
	$front = Zend_Controller_Front::getInstance();
	$front->addModuleDirectory(APPLICATION_PATH . '/modules/');
	$front->addControllerDirectory($controllerDirectory, 'cli');

	$front->setRequest($request);
	$front->setRouter(new Enterprise_Controller_Router_Cli());
	$front->setResponse(new Zend_Controller_Response_Cli());
	$front->throwExceptions(true);

	$front->dispatch();
}