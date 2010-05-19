<?php
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap {
	protected function _initPlugin() {
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Enterprise_Plugins_Admin_Login());
	}
}