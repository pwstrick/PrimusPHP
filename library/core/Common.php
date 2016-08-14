<?php

/**
 * PHP错误信息回调
 * @param $severity
 * @param $message
 * @param $filePath
 * @param $line
 */
function exception_error_handler($severity, $message, $filePath, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    $exception = InitPrimus::loadClass('\library\core\Exception');
    $exception->showPHPError($severity, $message, $filePath, $line);
}

/**
 * 追踪致命错误
 */
function catch_fatal_error() {
    // Getting Last Error
    $last_error =  error_get_last();
    // Check if Last error is of type FATAL
    if(isset($last_error['type']) && $last_error['type']==E_ERROR) {
        $exception = InitPrimus::loadClass('\library\core\Exception');
        $exception->showFatalError($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
        // Fatal Error Occurs
        // Do whatever you want for FATAL Errors
    }
}