<?php
/**
 * 微信逻辑
 */
class indexController extends \library\controller\Web {
    function index() {
        echo '<pre>';
        $tokenModel = new \library\model\wx\AccessToken();
        $tokens = $tokenModel->getRows();
        print_r($tokens);
        print_r(ConstEnum::$Enum_Select);
        echo 'hello world';
        echo '</pre>';
    }

    /**
     * 展示错误提示
     */
    function sign() {
        $wx = $this->getWeiXin();
    }

    /**
     * 路由重定向
     */
    public function config() {
        exit('"HTTP header Referer is missing"');
    }
}