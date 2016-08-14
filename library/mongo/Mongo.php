<?php
namespace library\mongo;
use MongoDB\BSON\ObjectID;

/**
 * Mongo通用类
 */
class Mongo {
    private $_db;
    protected $connect;
    protected $table;
    protected $collection;
    public function __construct() {
        $this->_db = \InitPrimus::loadClass('\library\db\Mongo');
    }

    /**
     * 数据库初始化
     */
    public function defaultConnect() {
        $this->connect = $this->_db->connect('default');
        return $this->connect;
    }

    /**
     * 添加
     * @param $row
     * @param array $options
     * @return string
     */
    public function add($row, $options = []) {
        return (string)$this->collection->insertOne($row, $options)->getInsertedId();
    }

    protected function setOptions($order=null, $size=null, $offset=0) {
        $options = [];
        if(!empty($order)) {
            $options['sort'] = $order;
        }
        if(!empty($size)) {
            $options['limit'] = $size;
        }
        if(!empty($offset)) {
            $options['skip'] = $offset;
        }
        return $options;
    }

    protected function setId($id) {
        $ids = [];
        if(is_array($id)) {
            foreach ($id as $key)
                $ids[] = new ObjectID($key);
            return [
                '_id' => ['$in' => $ids]
            ];
        }
        return [
            '_id' => new ObjectID($id)
        ];
    }

    /**
     * 获取多条信息
     * 操作符说明 https://docs.mongodb.com/manual/reference/operator/query-comparison/
     * $order 1正序 -1倒序
     * $field ['name':1]
     */
    public function getRows($where = array(), $order = null, $size = null, $offset = 0) {
        $options = $this->setOptions($order, $size, $offset);
        $rows = $this->collection->find($where, $options);
        return iterator_to_array($rows);
    }

    /**
     * 获取单条信息
     */
    public function getRow($where = array(), $order = null) {
        $options = $this->setOptions($order);
        return $this->collection->findOne($where, $options);
    }

    /**
     * 根据主键查询
     */
    public function getRowById($id) {
        return $this->getRow($this->setId($id));
    }

    /**
     * 根据主键列表查询
     */
    public function getRowByIds($ids, $order = null) {
        return $this->getRows($this->setId($ids), $order);
    }

    /**
     * 分页获取信息
     * @param array $where
     * @param null $order
     * @param int $page
     * @param int $size
     * @return mixed
     */
    public function getRowsLimitByPage($where = array(), $order = null, $page = 1, $size = 10) {
        return $this->getRows($where, $order, $size, ($page - 1) * $size);
    }

    /**
     * 更新
     * @param $row
     * @param $where
     */
    public function update($row, $where) {
        $row = [
          '$set' => $row
        ];
        $affected = $this->collection->updateMany($where, $row);
        return $affected->getModifiedCount();
    }

    /**
     * 根据主键更新
     * @param $id
     */
    public function updateById($id, $row) {
        $where = $this->setId($id);
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
            'status' => $status
        );
        return $this->updateById($id, $row);
    }
}