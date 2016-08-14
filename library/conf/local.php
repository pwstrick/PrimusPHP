<?php
/**
 * 测试环境全局配置
 */
$init_conf = array();

/**
 * MySQL数据库
 */
$init_conf['mysql']['default'] = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '123456',
    'database' => 'demo',
    'charset' => 'utf8mb4',
    'port' => '3306'
);

/**
 * Mongo数据库
 */
$init_conf['mongo']['default'] = array(
    'host' => '127.0.0.1:27017',
    'username' => '',
    'password' => '',
    'database' => 'demo',
    'option' => []
);

/**
 * 自动加载的辅助函数
 */
$init_conf['autoload']['helper'] = array(
    'file', 'url', 'regex'
);

/**
 * 重定向
 */
$init_conf['rewrite'] = array(
    '/new_bridge.js/' => 'index/config',
    '/new_bridge2.js/' => 'index/config2',
    '/p\/(\d+)/' => 'index/ticket?p=$1'
);