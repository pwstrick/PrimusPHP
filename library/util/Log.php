<?php
namespace library\util;
/**
 * 日志
 */
class Log {
    /**
     * 写日志
     * @param $txt
     */
    public function write($txt) {
        if(empty($txt) || !DEVELOPMENT_ENVIRONMENT) {
            return;
        }
        $name = date('Y-m-d') . '.log';
        if(!file_exists(LOG_PATH)) {
            mkdir(LOG_PATH, 0777, true);
        }
        $path = LOG_PATH . DS . $name;
        $content = date('Y-m-d H:i:s') . ' ' . $txt . "\n";
        file_put_contents($path, $content, FILE_APPEND);
    }
}