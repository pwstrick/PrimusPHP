<?php
namespace library\db;
require_once 'MySQL' . DS . 'medoo.php';
/**
 * DB初始化
 */
class MySQL  implements IDatabase {
    private $mysql = [];
    /**
     * 获取配置选项
     */
    private function _config($type) {
        $config = \InitPrimus::getConfig($type);
        return $config;
    }

    /**
     * MySQL库的初始化
     * @param $database
     * @return mixed
     */
    public function connect($database) {
        $config = $this->_config('mysql');
        $config = $config[$database];
        if(!isset($this->mysql[$database])) {
            $this->mysql[$database] = new \medoo(array(
                'database_type' => 'mysql',
                'database_name' => $config['database'],
                'server' => $config['host'],
                'port' => $config['port'],
                'username' => $config['username'],
                'password' => $config['password'],
                'charset' => $config['charset']
            ));
        }
        return $this->mysql[$database];
    }
}