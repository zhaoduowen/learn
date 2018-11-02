<?php
/**
 * @Author: wupengzheng
 * @Date:   2016/10/18 14:51
 * @Last Modified by:   wupengzheng
 * @Last Modified time: 2016/10/18 14:51
 */
require_once APPPATH . 'module/base_Model.php';

class M_infomation extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "web_infomation_master";
    }

    public function infomationType()
    {
        return $this->db->get("web_infomation_type_master")->result_array();
    }

    public function addInfomation($data)
    {
        if (empty($data)) {
            return false;
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateInfomation($condition = array(), $data = array())
    {
        if (empty($condition) || empty($data)) {
            return FALSE;
        }
        $this->db->where($condition);
        return $this->db->update($this->table, $data);
    }

    //列表
    public function infomation($where = array(), $limit = '', $offset = '', $type = 0)
    {
        if ($type == 0) {
            $condition = " count(*) as count ";
        }
        if ($type == 1) {
            $condition = " * ";
        }
        $sql = " select " . $condition . " from " .$this->table ." where status >= 0 ";
        if(!empty($where['keyword'])){
            $sql .= " and keywords like '%" . $where['keyword'] . "%' ";
        }
        if($where['type'] != ''){
            $sql .= " and web_infomation_type = " .$where['type'];
        }
        if(!empty($where['is_recommend'])){
            $sql .= " and flag_recommend = ".$where['is_recommend'];
        }
        if(!empty($where['startDate'])){
            $sql .= " and create_time >= '" . $where['startDate'] . " 00:00:00' ";
        }
        if (!empty($where['endDate'])) {
            $sql .= " and create_time <= " . '"' . $where['endDate'] . " 23:59:59" . '"';
        }
        //echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by create_time desc  limit {$limit},{$offset}";
            return $this->db->query($sql)->result_array();
        }
    }
    //查询单条数据
    public function selectInfomation($condition = array()){
        if (empty($condition)) {
            return FALSE;
        }
        return $this->db->get_where($this->table, $condition)->row_array();
    }
}

?>