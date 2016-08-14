<?php
namespace library\db;
/**
 * MongoDB 封装
 */
class Mongo implements IDatabase{
    private $mongo = [];

    public function __construct() {
        $dir = dir_join_ds([DB_LIB_PATH,'MongoDB']);
        \InitPrimus::addAutoLoadDir($dir);
        require_once(dir_join_ds([DB_LIB_PATH, 'MongoDB' , 'functions.php']));
    }

    /**
     * 配置项选取
     * @param $type
     * @return mixed
     */
    private function _config($type) {
        $config = \InitPrimus::getConfig($type);
        return $config;
    }

    /**
     * URI拼接
     * @param $config
     * @return string
     */
    private function _buildUri($config) {
        $uri = 'mongodb://';
        if (!empty($config['username'])) {
            $uri .= $config['username'];
        }
        if (!empty($config['password'])) {
            $uri .= ':' . $config['password'] . '@';
        }
        $host = $config['host'];
        if (\is_string($host)) {
            $host = [$host];
        }
        $uri .= implode(',', $host);
        $uri .= '/' . $config['database'];
        if (isset($config['option']) && \is_array($config['option'])) {
            $uri .= '?' . http_build_query($config['option']);
        }
        return $uri;
    }

    /**
     * 连接
     * @param $database
     * @return mixed
     */
    public function connect($database) {
        $config = $this->_config('mongo');
        $config = $config[$database];
        $uri = $this->_buildUri($config);
        if (!isset($this->mongo[$uri])) {
            $client = new \MongoDB\Client($uri);
            $this->mongo[$uri] = $client->$config['database'];
        }
        return $this->mongo[$uri];
    }
}