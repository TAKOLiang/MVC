<?php
// Database 的參數
define('DB_HOST', '127.0.0.1');
// define('DB_NAME', 'M2');
define('DB_USER', 'Liang');
define('DB_PASS', 'Hcvs912026');
define('DB_PORT', '3306');
// define('TABLE_NAME', ' ');

// App 根目錄，這是引入 app 資料夾裡的資源用的
define('APPROOT', dirname(dirname(__FILE__)) . '/');
define('PUBLICROOT', dirname(APPROOT) . "/public/");

define('VIEWS_PATH', APPROOT . 'views/');
const TABLE_PATH = APPROOT . 'database/';

// URL 根目錄，這是引入 public 資料夾裡的資源，或是頁面跳轉時用的
define('URLROOT', '/M2/');

// 網站名稱
define('SITENAME', 'M2');

define('MODEL_ROOT', '');
define('DB_PATH', '');

const STATIC_URL = 'static.mymvc.liangsite.com';
const WEB_URL = 'mymvc.liangsite.com';

switch (true) {
	case php_sapi_name() === 'cli':
		define('runType', 'auto');
		break;
	case isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest':
		define('runType', 'api');
		break;
	case (string) $_SERVER['HTTP_HOST'] === STATIC_URL:
		define('runType', 'static');
		$runType = 'static';
		break;
	default:
		define('runType', 'web');
		break;
}



