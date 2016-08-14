<?php
namespace library\core;

/**
 * 错误处理
 */
class Exception {

    /**
     * 显示PHP错误信息
     * @param $severity
     * @param $message
     * @param $filePath
     * @param $line
     */
    public function showPHPError($severity, $message, $filePath, $line) {
        ob_start();
        include(VIEW_LIB_PATH.DS.'error'.DS.'error_php.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

    /**
     * 显示404错误
     * @param string $heading
     * @param string $message
     */
    public function show404($heading = '404错误', $message = '当前页面不存在') {
        ob_start();
        include(VIEW_LIB_PATH.DS.'error'.DS.'error_404.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

    /**
     * 显示PHP致命错误
     * @param $severity
     * @param $message
     * @param $filePath
     * @param $line
     */
    public function showFatalError($severity, $message, $filePath, $line) {
        ob_start();
        include(VIEW_LIB_PATH.DS.'error'.DS.'error_fatal.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }
}
