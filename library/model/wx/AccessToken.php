<?php
namespace library\model\wx;
/**
 * Token操作
 */
class AccessToken extends \library\model\Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'wx_access_token';
        $this->defaultConnect();
    }
}