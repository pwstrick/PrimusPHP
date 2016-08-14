<?php
namespace library\core;

/**
 * 路由类
 */
class Router {
    private $uri;
    function __construct() {
        $this->uri = ltrim($_SERVER['REQUEST_URI'],'/');
        $this->route();
    }

    /**
     * 路由重定向
     */
    public function rewrite() {
        $config = \InitPrimus::getConfig('rewrite');
        foreach ($config as $src => $redirect) {
            //$pattern = '@^\/?' . $src . '\/?$@';
            if (\preg_match($src, $this->uri)) {
                $this->uri = \preg_replace($src, $redirect, $this->uri);
                break;
            }
        }
    }

    /**
     * 路由选择
     */
    public function route() {
        $this->rewrite();
        $uri = $this->uri;
        $pos = strpos($uri, '?');
        //排除?后面的参数
        if ($pos)
            $uri = substr($this->uri,0, $pos);
        $params = explode('/', $uri);
        if(count($params) == 2) {
            $controller = $params[0];//控制器
            $action = $params[1];//操作方法
        }elseif(count($params) == 3) {
            $module = $params[0]; //模块
            $controller = $params[1];//控制器
            $action = $params[2];//操作方法
        }else {
            $controller = 'index';
            $action = 'index';
        }

        $controllerName = $controller.'Controller';
        $paths = [APP_PATH, APP_NAME, 'controllers'];
        //模块
        if(isset($module)) {
            array_push($paths, $module);
        }
        array_push($paths, $controllerName .'.php');
        $filePath = implode(DS, $paths);
        //判断是否存在控制器
        if(!file_exists($filePath)) {
            $this->_error404();//打印404页面
            return;
        }
        include_once $filePath;
        $handler = new $controllerName;
        //判断是否存在action
        if(!method_exists($handler, $action)) {
            $this->_error404();
            return;
        }
        $handler->$action();
    }

    /**
     * 404错误显示
     */
    private function _error404() {
        $exception = \InitPrimus::loadClass('\library\core\Exception');
        $exception->show404();
    }
}