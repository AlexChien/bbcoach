<?php

class Enterprise_Model {
	protected $_db;
	public function __construct(){
		$this->_db = Zend_Registry::get('db');
	}
}