<?php
define('ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT . DS . 'app');
define('LIB_PATH', ROOT . DS . 'library');
define('THIRD_LIB_PATH', LIB_PATH . DS . 'third');
define('DB_LIB_PATH', LIB_PATH . DS . 'db');
define('HELPER_LIB_PATH', LIB_PATH . DS . 'helper');
define('VIEW_LIB_PATH', LIB_PATH . DS . 'view');
define('PUBLIC_PATH', ROOT . DS . 'public');
define('LOG_PATH', ROOT . DS . 'log');//日志位置

require_once LIB_PATH . DS . 'init.php';