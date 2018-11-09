<?php

require_once APPPATH.'module/base_Model.php';
class M_ad extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "ad_master";
    }

  
    public function getPosition(){
        return $this->db->get_where('ad_position',array('status' => 1))->result_array();
    }
    public function getAdPic($lesson_id){
        return $this->db->get_where('ad_pic',array('ad_id' => $lesson_id))->result_array();
    }

	//列表
    public function getList($where = array(), $limit = '', $offset = '', $type = 0)
    {
        if ($type == 0) {
            $condition = " count(*) as count ";
        }
        if ($type == 1) {
            $condition = " * ";
        }
        $sql = " select " . $condition . " from " .$this->table ." where status>=1";
        if(!empty($where['keyword'])){
            $sql .= " and title like '%" . $where['keyword'] . "%' ";
        }
        
           if($where['keyword'] != ''){
            $sql .= " and title = " .$where['keyword'];
        }
        //echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by ordern asc  limit {$limit},{$offset}";
            $data = $this->db->query($sql)->result_array();
           
            return $data;
        }

    }
	









    
}