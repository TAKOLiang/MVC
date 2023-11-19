<?php
// Database 的參數
define('DB_HOST', '127.0.0.1');
// define('DB_NAME', 'M2');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_PORT', '3306');
// define('TABLE_NAME', ' ');

// App 根目錄，這是引入 app 資料夾裡的資源用的
define('APPROOT', dirname(dirname(__FILE__)) . '/');

define('VIEWS_PATH',APPROOT.'views/');
CONST TABLE_PATH = APPROOT.'database/';

// URL 根目錄，這是引入 public 資料夾裡的資源，或是頁面跳轉時用的
define('URLROOT', '/M2/');

// 網站名稱
define('SITENAME', 'M2');

define('MODEL_ROOT','');

define('DB_PATH','');

if(php_sapi_name() ==='cli') {
	define('runType','auto');
}else if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	define('runType','API');
}else{
	define('runType','web');
}



