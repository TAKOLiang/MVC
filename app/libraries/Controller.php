<?php
class Controller {
	// 載入 model
	public static function model($model) {
		require_once './app/models/' . $model . '.php';
		// require_once APPROOT."" ;
		return new $model();
	}

	// 載入 view
	// 其中 view 可能有需要從 Controller 帶過去的資料，故多了 $data 陣列作為第二個參數
	public function view($view, array $data = []) {
		// 如果檔案存在就引入它
		if (file_exists('./app/views/' . $view . '.php')) {
			require_once './app/views/' . $view . '.php';
		} else {
			require_once './app/views/errorPage.php';
			//die('View does not exist');
		}
	}

	protected function jsmin($file){
		
	}

	// public function database($table, $db = '') {
	// 	if($db !=''){
	// 		$table_path = "./app/database/{$db}/{$table}.php"; 
	// 	}else{
	// 		$table_path = "./app/database/{$table}.php";
	// 	}

	// 	if(file_exists($table_path)){
	// 		require_once $table_path;
	// 		return new $table();
	// 	}else{
	// 		die("database file not found !! \r\n");
	// 	}
	// }
}
