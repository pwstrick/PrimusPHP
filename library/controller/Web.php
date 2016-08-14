<?php
namespace library\controller;
/**
 * 微信前端通用接口
 */
class Web extends \library\core\Controller{

    /**
     * 过滤接收的数据
     * @param $name
     * @param bool $isFilter
     * @return null
     */
    protected function p($name=null, $isFilter=true) {
        if(empty($name))
            return $_REQUEST;
        if(!isset($_REQUEST[$name]))
            return null;
        return $_REQUEST[$name];//TODO filter
    }
}