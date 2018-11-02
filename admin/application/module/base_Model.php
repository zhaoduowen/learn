<?php
/**
 * @Author: tongkun
 * @Date:   2016-03-07 19:38:21
 * @Last Modified by:   tongkun
 * @Last Modified time: 2016-03-07 20:16:28
 */


/**
 * 	基类model
 */
class Base_Model extends CI_Model
{
	protected $table;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 向表里插入一条数据
	 * @param  array  $data 数组
	 * @return BOOL         操作结果
	 */
	public function insert($data = array()) {
		if (empty($data)) {
			return FALSE;
		}
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	/**
	 * 向表里插入多条数据
	 * @param  array  $data 二维数组数据
	 * @return BOOL         插入结果
	 */
	public function insertBatch($data = array()) {
		if (empty($data)){
			return FALSE;
		}
		return $this->db->insert_batch($this->table, $data);
	}

	/**
	 * 获取数据列表
	 * @param  array  $condition 条件
	 * @return array             查询结果
	 */
	public function get($condition = array()) {
		if (empty($condition)) {
			return FALSE;
		}
		return $this->db->get_where($this->table, $condition)->result_array();
	}

	/**
	 * 获取一条数据
	 * @param  array  $condition 条件
	 * @return array             一维数组
	 */
	public function getRow($condition = array()) {
		if (empty($condition)) {
			return FALSE;
		}
		return $this->db->get_where($this->table, $condition)->row_array();
	}

	/**
	 * 更新数据
	 * @param  array  $condition 更新条件
	 * @param  array  $data      需要更新的数据
	 * @return BOOL              返回结果
	 */
	public function update($condition = array(), $data = array()) {
		if (empty($condition) || empty($data)) {
			return FALSE;
		}
		$this->db->where($condition);
		return $this->db->update($this->table, $data);
	}

                /**
     * 符合分页查询，仅限于left，right，inner join
     * @param type $order 排序条件
     * @param type $map 查询条件参数
     * @param type $offset 起始位置
     * @param type $limit 查询条数
     * @param array $join_table 要连接的table，数组
     * @param type $field 字段名
     * @return count总数  data 数据集
     * @author zhang jian
     */
    public function select($order, $map, $offset, $limit = 10, $join_table = array(), $field = '*') {
        unset($map['page']); //去除检索条件中的page
        empty($map) ? '' : $this->db->where($map); //检索条件
        if (!empty($join_table) && is_array($join_table)) {
            foreach ($join_table as $k => $v) {
                $this->join_table($v['table'], $v['condition'], $v['type']);
            }
        }
        $count = $this->db->count_all_results($this->table); //统计总数
        empty($map) ? '' : $this->db->where($map); //检索条件
        empty($order) ? $this->db->order_by('id desc') : $this->db->order_by($order); //排序，默认是id降序
        $this->db->limit($limit, $offset); //分页
        $this->db->select($field);
        $this->db->from($this->table);
        if (!empty($join_table) && is_array($join_table)) {
            foreach ($join_table as $k => $v) {
                $this->join_table($v['table'], $v['condition'], $v['type']);
            }
        }
        $query = $this->db->get();
        $data = $query->result_array(); //获取数据集
        return array('count' => $count, 'data' => $data);
    }

    /**
     * 返回关联join语句
     * @param type $join_table 关联的表名
     * @param type $condition 检索条件
     * @param type $type 关联方式
     * @return type
     * @author zhang jian
     */
    private function join_table($join_table, $condition, $type) {
        return $this->db->join($join_table, $condition, $type);
    }



}