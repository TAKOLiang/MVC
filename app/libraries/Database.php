<?php
class Database {
	// 設定資料庫的常數來自於 config/config.php
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $port = DB_PORT;
	private $dbname;

	// 定義一些操作 Database 的變數，例如：
	private $dbh;
	private $stmt;
	private $error;
	private $conn;
	private $sql;
	private $col = '*';
	private $orderby = '';
	private $where = 'WHERE 1=1 ';
	private $table;
	private $limit = '';

	const ASC = "ASC";
	const DESC = "DESC";


	function __construct() {
		$called_class_arr = explode('\\', get_called_class());
		$this->dbname = $called_class_arr[0];
		$this->table = $called_class_arr[1];
		$this->conn = $this->connect();
	}

	private function connect() {
		// 透過 PDO 建立資料庫連線
		// 實例化 PDO
		try {
			$pdo_str = "mysql:host={$this->host};charset=utf8;port={$this->port};dbname={$this->dbname}";
			// $pdo_str = "mysql:host={$this->host};charset=utf8;port={$this->port};";
			$conn = new PDO($pdo_str, $this->user, $this->pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
			//echo "Connected Successfully";
		} catch (PDOException $e) {
			// echo "Connection failed: " . $e->getMessage();
		}
	}

	// Bind values
	// public function bind() {
	// }

	// execute
	public function execute($sql = "", $data = []) {
		$this->conn->exec("SET NAMES utf8mb4");
		$stmt = $this->conn->prepare($sql);
		$result = false;
		try {
			$result = $stmt->execute($data);
			$result = true;
		} catch (PDOException $e) {
			// echo $e->getMessage();
			return false;
		}

		return $result;
	}

	// 取得資料表的所有資料
	public function getAll($sql, $data = []) {
		$prepare = $this->conn->prepare($sql);
		try {
			$query = $prepare->execute($data);
			return $prepare->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			// echo $e->getMessage();
			return false;
		}
	}


	public function insert($table, $arrField, $returnID = false) {

		if (empty($arrField)) {
			return false;
		}

		$sql = null;

		$array_table_column = array_keys($arrField);
		$array_column_value = array();

		$column = $array_table_column[0];
		$value = "?";

		for ($i = 0; $i < count($array_table_column); $i++) {
			$array_column_value[$i] = $arrField[$array_table_column[$i]];

			if ($i != 0) {
				$column .= "," . $array_table_column[$i];
				$value .= ", ?";
			}
		}
		$this->conn->exec("SET NAMES utf8mb4");
		// debugOutput($sql, $conn, true);
		$sql = "INSERT INTO {$table} ({$column}) VALUES ({$value})";
		$stmt = $this->conn->prepare($sql);

		try {
			$result = $stmt->execute($array_column_value);
		} catch (PDOException $e) {
			// echo $e->getMessage();
			return false;
		}

		return $returnID ? $this->conn->lastInsertId() : $result;
	}

	public function update($table, $arrField, $whereClause = '') {

		if (empty($arrField)) {
			return false;
		}

		$sql = null;

		$array_table_column = array_keys($arrField);
		$array_column_value = array();

		$set = $array_table_column[0] . "=?";

		for ($i = 0; $i < count($array_table_column); $i++) {
			$array_column_value[$i] = $arrField[$array_table_column[$i]];
			if ($i != 0) {
				$set .= ", " . $array_table_column[$i] . "=?";
			}
		}
		$this->conn->exec("SET NAMES utf8mb4");
		// debugOutput($sql, $conn, true);

		if (is_array($whereClause)) {
			$index = 0;
			$where_set = '';
			foreach ($whereClause as $key => $value) {
				$array_column_value[] = $value;
				if ($index != 0) {
					$where_set = $where_set . ' AND ';
				}

				$where_set .= $key . "=?";
				$index++;
			}

			$sql = "UPDATE {$table} SET {$set} WHERE {$where_set}";
		} else {
			$sql = "UPDATE {$table} SET {$set} WHERE {$whereClause}";
		}

		$stmt = $this->conn->prepare($sql);
		try {
			$result = $stmt->execute($array_column_value);
		} catch (PDOException $e) {
			// echo $e->getMessage();
			return false;
		}

		return $result;
	}

	public function deleteAll($table) {
		$this->conn->exec("SET NAMES utf8mb4");
		$sql = "DELETE FROM $table";
		$result = false;
		try {
			$affectedRow = $this->conn->exec($sql);
			$result = true;
		} catch (PDOException $e) {
			return false;
		}

		return $result;
	}

	public function delete($table, $whereClause = '') {
		$this->conn->exec("SET NAMES utf8mb4");
		$array_column_value = [];
		if (is_array($whereClause)) {
			$index = 0;
			$where_set = '';
			foreach ($whereClause as $key => $value) {
				$array_column_value[] = $value;
				if ($index != 0) {
					$where_set = $where_set . ' AND ';
				}

				$where_set .= $key . "=?";
				$index++;
			}

			$sql = "DELETE FROM {$table} WHERE {$where_set}";
		} else {
			$sql = "DELETE FROM {$table} WHERE {$whereClause}";
		}

		$stmt = $this->conn->prepare($sql);
		try {
			$result = $stmt->execute($array_column_value);
		} catch (PDOException $e) {
			// echo $e->getMessage();
			return false;
		}

		return $result;
	}

	public function select($table, $col = '') {

	}

	public function tableCol(...$col) {
		if ($col == '')
			return $this;
		$this->col = implode(',', $col);
		return $this;
	}

	/**
	 * @param string $where string sql where
	 * @param string|null $symbol
	 */
	public function where($where, $symbol = null) {
		if ($where == '')
			return $this;
		$symbol = $symbol ?? 'AND';
		$this->where .= " {$symbol} ({$where})";
		return $this;
	}

	public function leftjoin($table) {
	}

	public function jointable() {
	}

	public function limit(...$limit) {
		if (count($limit) != 2)
			return $this;
		$this->limit = "LIMIT {$limit[0]},{$limit[1]}";
		return $this;
	}

	/**
	 * @param  array $orderby setting sql orderby array colname => asc
	 */
	public function orderby(...$orderby) {
		if (count($orderby) % 2 != 0)
			return $this;
		$order_arr = array_chunk($orderby, 2);
		$this->orderby = " ORDER BY " . implode(',', array_map(function ($el) {
			return " {$el[0]} $el[1]";
		}, $order_arr));
		return $this;
	}

	public function query() {
		// $this->table = (new Exception())->getTrace()[1]['class'];
		$this->sql = "SELECT {$this->col} from {$this->table} {$this->where} {$this->orderby} {$this->limit}";
		$this->col = '*';
		$this->where = 'WHERE 1=1';
		$this->orderby = '';
		$this->limit = '';
		$prepare = $this->conn->prepare($this->sql);
		try {
			$prepare->execute();
			$result = $prepare->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	public function begin() {
		return $this->conn->beginTransaction();
	}

	public function commit() {
		return $this->conn->commit();
	}

	public function rollback() {
		return $this->conn->rollBack();
	}


	// 以下是 Model 可以操作資料庫的幾個預設方法
	// 可以自行定義更多需要的或常用的

	// 取得資料表的單一筆資料
	public static function getSingle($sql, $data) {
	}
	// 取得資料表中資料的筆數
	public function getRowCount() {
	}
}
