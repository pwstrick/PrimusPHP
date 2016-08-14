<?php
/**
 * 与文件相关的操作函数 包括路径
 */

/**
 * 路径整理 正斜杠与反斜杠
 * windows路径正斜杠“/”和反斜杠“\”都可以 UNIX必须正斜杠“/”
 * @param $dir
 * @return string
 */
if(!file_exists('dir_replace_ds')) {
    function dir_replace_ds($dir) {
        return rtrim(str_replace('\\', DS, $dir), DS);
    }
}


/**
 * 用于路径的拼接
 * @param $array
 * @return string
 */
if(!file_exists('dir_join_ds')) {
    function dir_join_ds($array) {
        return implode($array, DS);
    }
}
