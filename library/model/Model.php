<?php
namespace library\model;
/**
 * 模型层通用
 */
class Model {
    private $_db;
    protected $connect;
    protected $table;
    protected $primaryKey = 'id';
    public function __construct() {
        $this->_db = \InitPrimus::loadClass('\library\db\MySQL');
    }

    /**
     * 数据库初始化
     */
    public function defaultConnect() {
        $this->connect = $this->_db->connect('default');
        return $this->connect;
    }

    protected function writeLog() {
        $logs = $this->connect->log();
        \InitPrimus::writeLog(array_pop($logs));
    }

    /**
     * 执行复杂的SQL
     * http://php.net/manual/zh/class.pdostatement.php
     * @param $sql
     * @return PDOStatement对象
     */
    public function query($sql) {
        $query = $this->connect->query($sql);
        $this->writeLog();
        return $query;
    }

    /**
     * 获取数量
     * @param array $where
     * @param string $field
     * @param bool $distinct
     * @return string
     */
    public function getCount($where = [], $field = '*', $distinct = FALSE) {
        $where = $this->setWhere($where);
        if($distinct) {
            if(empty($field) || $field == '*') {
                $field = $this->primaryKey;
            }
            $sql = 'SELECT COUNT(DISTINCT('.$field.')) FROM ' . $this->table . $this->connect->where_clause($where);
            $query = $this->connect->query($sql);
            $count = $query ? 0 + $query->fetchColumn() : 0;
        }else {
            $count = $this->connect->count($this->table, $where);
        }
        $this->writeLog();
        return $count;
    }

    /**
     * 插入一条数据
     * @param $row
     * @return mixed
     */
    public function add($row) {
        $autoId = $this->connect->insert($this->table, $row);
        $this->writeLog();
        return $autoId;
    }

    protected function setWhere($where, $order=null, $size=null, $offset=0) {
        $newWhere = [];
        if(!empty($where)) {
            $newWhere['AND'] = $where;
        }
        if(!empty($order)) {
            $newWhere['ORDER'] = $order;
        }
        if(!empty($size)) {
            $newWhere['LIMIT'] = [$offset, $size];
        }
        return $newWhere;
    }

    /**
     * 获取多条信息
     */
    public function getRows($where = array(), $order = null, $size = null, $offset = 0, $field = '*') {
        $where = $this->setWhere($where, $order, $size, $offset);
        $rows = $this->connect->select($this->table, $field, $where);
        $this->writeLog();
        return $rows;
    }

    /**
     * 获取单条信息
     */
    public function getRow($where = array(), $order = null, $field = '*') {
        $where = $this->setWhere($where, $order);
        $row = $this->connect->get($this->table, $field, $where);
        $this->writeLog();
        return $row;
    }

    /**
     * 根据主键查询
     */
    public function getRowById($id, $field = '*') {
        return $this->getRow([$this->primaryKey => $id], null, $field);
    }

    /**
     * 根据主键列表查询
     */
    public function getRowByIds($ids, $order = null, $field = '*') {
        return $this->getRows([$this->primaryKey => $ids], $order, $field);
    }

    /**
     * 分页获取信息
     * @param array $where
     * @param null $order
     * @param int $page
     * @param int $size
     * @param string $field
     * @return mixed
     */
    public function getRowsLimitByPage($where = array(), $order = null, $page = 1, $size = 10, $field = '*') {
        return $this->getRows($where, $order, $size, ($page - 1) * $size, $field);
    }

    /**
     * 更新
     * @param $row
     * @param $where
     */
    public function update($row, $where) {
        $where = $this->setWhere($where);
        $affected = $this->connect->update($this->table, $row, $where);
        $this->writeLog();
        return $affected;
    }

    /**
     * 根据主键更新
     * @param $id
     */
    public function updateById($id, $row) {
        $where = array(
          $this->primaryKey => $id
        );
        return $this->update($row, $where);
    }

    /**
     * 根据主键更新状态
     * @param $id
     */
    public function updateStatusById($id, $status = null) {
        if(is_null($status)) {
            $status = \ConstEnum::Status_Normal;
        }
        $row = array(
          'status' => \ConstEnum::Status_Normal
        );
        return $this->updateById($id, $row);
    }
}