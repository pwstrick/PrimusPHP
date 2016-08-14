<?php
namespace library\db;
/**
 * 数据库接口
 */
interface IDatabase {
    public function connect($database);
}