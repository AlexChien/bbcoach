<?php

/**
 * @name Admin_Model_Log
 * @desc read log file and explode it for use
 * @author Pascal
 *
 */
class Admin_Model_Logs {

	public function __construct($type) {
		$table = array();
		$file = APPLICATION_PATH . '/../datas/logs/' . $type . 'log.csv';
		$string = file_get_contents($file);
		$content = explode("\r\n", $string);
		foreach ($content as &$line) {
			$e = explode(';', $line);
			$table[] = array('date' => $e[0], 'content' => $e[1]);
		}
		// print var_dump($table);exit;
		return $table;
	}

}