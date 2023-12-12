<?php

class Core {
	// 預設 Controller 為 Pages
	protected $currentController = 'index';
	// 預設方法為 index
	protected $currentMethod = 'home';
	// 預設參數為空
	protected $params = [];

	public function __construct() {
		call_user_func([$this, runType]);
	}

	public function getUrl() {

		// 從 public?url= 後開始，將 $url 按 / 切分，轉換成陣列並回傳
		// 例如： 使用者輸入 127.0.0.1/public?url=posts/show/1
		// 則回傳 $url 的值為 ['posts', 'show', 1]
		// 它將在 __construct() 中依序被解析成 Controller, 方法, 參數
		if (isset($_GET['url'])) {
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}

	private function auto() {
		dd(__METHOD__);
	}

	private function api() {
		dd(__METHOD__);
		// 呼叫 getUrl() 取得 $url 陣列
		$url = $this->getUrl();
		// 將 $url[0] 視為 Controller 的名稱
		// 檢查 $url[0] 是否有對應的 Controller ，即是否存在 $url[0].php 的檔案

		if (file_exists('./app/controllers/' . $url[0] . '.php')) {
			$this->currentController = $url[0];
		}

		// 引入 Controller
		// 實例化 Controller
		require_once './app/controllers/' . $this->currentController . '.php';
		$this->currentController = new $this->currentController;


		if (isset($url[1])) {
			// $url[1] 視為 Controller 中的方法(頁面)
			// 所以先要檢查是否有值，若有，檢查該值是否有對應的方法
			if (method_exists($this->currentController, $url[1])) {
				$this->currentMethod = $url[1];
				unset($url[1]);
			} else {
				require_once './app/views/errorPage.php';
				exit;
			}
		}

		// $url 陣列中的第三個值開始，視為帶入方法中的參數
		// 用 $params 陣列儲存所有剩下的值
		$this->params = $url ? array_values($url) : [];

		// 最後透過呼叫 callback 來執行方法
		call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
	}

	protected function web() {
		// 呼叫 getUrl() 取得 $url 陣列
		$url = $this->getUrl();
		// 將 $url[0] 視為 Controller 的名稱
		// 檢查 $url[0] 是否有對應的 Controller ，即是否存在 $url[0].php 的檔案
		if (file_exists('./app/controllers/' . $url[0] . '.php')) {
			$this->currentController = $url[0];
		}
		define('CONTROLLER', $this->currentController);


		// 引入 Controller
		// 實例化 Controller
		require_once './app/controllers/' . $this->currentController . '.php';
		$this->currentController = new $this->currentController;

		if (isset($url[1])) {
			// $url[1] 視為 Controller 中的方法(頁面)
			// 所以先要檢查是否有值，若有，檢查該值是否有對應的方法
			if (method_exists($this->currentController, $url[1])) {
				$this->currentMethod = $url[1];
				unset($url[1]);
			} else {
				require_once './app/views/errorPage.php';
				exit;
			}
		}
		define('METHOD', $this->currentMethod);

		// $url 陣列中的第三個值開始，視為帶入方法中的參數
		// 用 $params 陣列儲存所有剩下的值
		$this->params = $url ? array_values($url) : [];

		// 最後透過呼叫 callback 來執行方法
		call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
	}

	protected function static() {
		[$type, $file] = $this->getStatic();
		// $static_path   = PUBLICROOT . "{$type}/" . implode('/', $file);
		// if (!file_exists($static_path)) exit('');
		if($file == '') exit;
		require_once APPROOT . 'libraries/plugin/minify/vendor/autoload.php';

		$upper_type = strtoupper($type);
		$obj_name   = "MatthiasMullie\\Minify\\{$upper_type}";
		$obj        = new $obj_name($file);

		// $js = file_get_contents($static_path);
		$js          = $obj->minify();
		$contentType = $type == 'css' ? 'text/css' : 'application/x-javascript';
		header("Content-Type:{$contentType}");
		echo $js;
	}

	protected function getStatic() {
		if (isset($_GET['url'])) {
			require_once APPROOT . 'config/static_list.php';
			$url         = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
			$static_arr  = explode('-', array_shift($url));
			$lastElement = explode('.', end($static_arr));
			$static_type = end($lastElement);

			$static_name = implode('-', $static_arr);
			if (!empty($_STATIC[$static_type][$static_name])) {
				$static_file = '';
				$staticList = $_STATIC[$static_type][$static_name];
				foreach ($staticList as $val) {
					$item_path = PUBLICROOT . "{$static_type}/com/{$val}";
					if (file_exists($item_path)) $static_file .= file_get_contents($item_path);
				}

				$static_path = PUBLICROOT . "{$static_type}/".implode('/',$static_arr);
				if (file_exists($static_path)) $static_file .= "\r\n".file_get_contents($static_path);

				return [$static_type,$static_file];
			}
			// return [$static_type, $static_arr];
		}
	}
}
