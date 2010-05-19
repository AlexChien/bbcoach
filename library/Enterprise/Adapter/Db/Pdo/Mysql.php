<?php

/**
 * Based on Enterprise_Adapter_Pdo_Mysql.insert method
 * add method for MySQL REPLACE function
 * @author Pascal
 *
 */
class Enterprise_Adapter_Db_Pdo_Mysql extends Zend_Db_Adapter_Pdo_Mysql {
	public function replace($table, array $bind) {
		$cols = array();
		$vals = array();
		foreach ($bind as $col => $val) {
			$cols[] = $this->quoteIdentifier($col, true);
			if($val instanceof Zend_Db_Expr) {
				$vals[] = $val->__toString();
				unset($bind[$col]);
			}
			else {
				$vals[] = '?';
			}
		}
		$sql = "REPLACE INTO " . $this->quoteIdentifier($table, true) . ' (' . implode(', ', $cols) . ') ' . 'VALUES (' . implode(', ', $vals) . ')';
		$stmt = $this->query($sql, array_values($bind));
		$result = $stmt->rowCount();
		return $result;
	}
}