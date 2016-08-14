<?php
require_once('const.enum.php');
require_once('core/Common.php');

class InitPrimus {
    private static $instances = array(); //单例容器
    private static $mine;
    private static $log;
    private static $autoDirs = [LIB_PATH];//默认的自动载入路径
    private static $config;
    public static function getInstance() {
        if (empty($mine)) {
            self::$mine = new self();
        }
        return self::$mine;
    }

    /**
     * 初始化类
     * @param $name
     * @return Object
     */
    public static function loadClass($name) {
        if (!isset(self::$instances[$name])) {
            $initClass = new $name;
            self::$instances[$name] = $initClass;
        }
        return self::$instances[$name];
    }

    /**
     * 载入helper文件夹中的函数
     * @param $name
     */
    public static function loadFunction($name) {
        if(is_array($name)) {
            foreach ($name as $key) {
                include_once HELPER_LIB_PATH .  DS . $key . '_helper.php';
            }
        }else {
            include_once HELPER_LIB_PATH .  DS . $name . '_helper.php';
        }
    }

    private function __construct() {
        $this->environment();//环境配置
        //try{
            $this->reporting();//错误报告
            self::loadFunction(self::$config['autoload']['helper']);//加载辅助函数
            $this->_autoload();//自动载入
            self::openLog(); //开启log
            self::loadClass('\library\core\Router');//路由
            //$this->_db();
            //self::getConfig();
//        }catch (Exception $e) {
//            print_r($e->getMessage());
//            //print_r($e);
//        }
    }

    /**
     * 判断当前环境
     */
    function environment() {
        $name = getenv('ENVIRONMENT');
        switch ($name) {
            case 'local':
                $this->_setEnvironment(true, $name);
                break;
            case 'develop':
                $this->_setEnvironment(true, $name);
                break;
            case 'product':
                $this->_setEnvironment(false, $name);
                break;
        }
    }

    /**
     * @param $isEnvironment
     * @param $name
     */
    private function _setEnvironment($isEnvironment, $name) {
        define('DEVELOPMENT_ENVIRONMENT', $isEnvironment);
        include_once('conf' . DS . $name . '.php');
        include_once(CONFIG_PATH . DS . $name. '.php');//项目中的自定义配置文件
        //global $init_conf;
        self::$config = $init_conf;//include进来的变量
//        print_r($this->_config);
    }

    function reporting() {
        if (DEVELOPMENT_ENVIRONMENT) {
            set_error_handler('exception_error_handler');//追踪错误栈
            register_shutdown_function('catch_fatal_error');//致命错误
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', LOG_PATH . DS . 'error.log');
        }
    }

    /**
     * 添加自动载入的路径
     * @param $dir
     */
    public static function addAutoLoadDir($dir) {
        self::$autoDirs[] = dir_replace_ds($dir);
    }

    /**
     * 自动载入
     */
    private function _autoload() {
        //$className是通过命名空间获取的
        spl_autoload_register(function ($className) {
            $dir = false;
            $classNames = explode('\\', $className);//分割为数组
            $autoDirs = self::$autoDirs;
            foreach ($autoDirs as $path) {
                $tmpInfo = pathinfo($path);
                if(in_array($tmpInfo['basename'], $classNames)) {
                    $dir = $tmpInfo['dirname'];
                    break;
                }
            }

            if($dir) {
                $file = $dir . DS . dir_replace_ds($className) . '.php';
                include_once($file);
            }
        });
    }

    /**
     * 获取全局配置文件
     * 全局使用方法：InitPHP::getConfig('controller.path')
     * @param string $path 获取的配置路径 多级用点号分隔
     * @return mixed
     */
    public static function getConfig($path='') {
        $init_conf = self::$config;
        if (empty($path)) return $init_conf;
        $tmp = $init_conf;
        $paths = explode('.', $path);
        foreach ($paths as $item) {
            $tmp = $tmp[$item];
        }
        return $tmp;
    }

    /**
     * 打开Log日志对象
     */
    public static function openLog() {
        self::$log = self::loadClass('\library\util\Log');
    }

    /**
     * 写LOG
     * @param $txt
     */
    public static function writeLog($txt) {
        self::$log->write($txt);
    }
}
