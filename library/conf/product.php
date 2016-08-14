<?php



/**
 * 正式环境全局配置
 */
$init_conf = array();

/**
 * MySQL数据库
 */
$init_conf['mysql']['default'] = array(

);

/**
 * Mongo数据库
 */
$init_conf['mongo']['default'] = array(

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
    '/new_bridge.js/' => 'index/config'
);