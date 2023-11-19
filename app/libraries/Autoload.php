<?php
class Autoload {
	public function loadTable($table) {
		$tableFile = TABLE_PATH . "{$table}.php";
		if (file_exists($tableFile)) {
			require_once $tableFile;
		}
	}
}

spl_autoload_register([new Autoload(), 'loadTable']);
?>