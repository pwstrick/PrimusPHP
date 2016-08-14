<?php
/**
 * 正则表达式
 */

/**
 * 验证手机号码
 */
function regex_mobile($str) {
    return preg_match("/^\d{11}$/", $str) > 0;
}