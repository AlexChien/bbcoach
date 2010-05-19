<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected $_config;

	protected function _initConfig() {
		$this->_config = new Zend_Config($this->getOptions());
		Zend_Registry::set('config', $this->_config);
		/*$front = Zend_Controller_Front::getInstance();
		$front->setParam('noErrorHandler', true);*/
	}

	protected function _initAutoLoader() {
		$classFileIncCache = APPLICATION_PATH . '/../datas/cache/pluginLoaderCache.php';
		if(file_exists($classFileIncCache)) {
			include_once $classFileIncCache;
		}
		if($this->_config->enablePluginLoaderCache) {
			Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);
		}
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Enterprise_');
	}

	protected function _initLog() {
		$logger = new Enterprise_Log_Firebug((bool) $this->_config->phpSettings->display_errors);
		Zend_Registry::set('logger', $logger);
	}

	protected function _initDb() {
		try {
			$db = Zend_Db::factory($this->_config->resources->db);
			$db->getConnection();
			$db->query("SET NAMES 'utf8'");
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			Zend_Registry::set('db', $db);
		} catch (Exception $e) {
			Zend_Registry::set('db', false);
		}
	}

}