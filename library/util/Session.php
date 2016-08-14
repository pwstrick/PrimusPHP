<?php
namespace library\util;
/**
 * Session操作
 */
class Session {
    /**
     * Session-设置session值
     * 使用方法：$this->getUtil('session')->set('ccccccc', 'dddddd');
     * @param  string $key    key值，可以为单个key值，也可以为数组
     * @param  string $value  value值
     * @return string
     */
    public function set($key, $value='') {
        if (!session_id()) $this->start();
        if (!is_array($key)) {
            $_SESSION[$key] = $value;
        } else {
            foreach ($key as $k => $v) $_SESSION[$k] = $v;
        }
        return true;
    }

    /**
     * Session-获取session值
     * 使用方法：$this->getUtil('session')->get('ccccccc');
     * @param  string $key    key值
     * @return string
     */
    public function get($key) {
        if (!session_id()) $this->start();
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : NULL;
    }

    /**
     * Session-删除session值
     * 使用方法：$this->getUtil('session')->del('ccccccc');
     * @param  string $key    key值
     * @return string
     */
    public function del($key) {
        if (!session_id()) $this->start();
        if (is_array($key)) {
            foreach ($key as $k){
                if (isset($_SESSION[$k])) unset($_SESSION[$k]);
            }
        } else {
            if (isset($_SESSION[$key])) unset($_SESSION[$key]);
        }
        return true;
    }

    /**
     * Session-清空session
     * 使用方法：$this->getUtil('session')->clear();
     */
    public function clear() {
        if (!session_id()) $this->start();
        session_destroy();
        $_SESSION = array();
    }

    /**
     * Session-session_start()
     * @return string
     */
    private function start() {
        session_start();
    }
}