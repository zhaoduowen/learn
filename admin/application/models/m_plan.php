<?php

require_once APPPATH.'module/base_Model.php';
class M_plan extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "plan_master";
    }

    public function getPlanType(){
        return array(
            '1' => '个人',
            '2' => '企业',
        );
    }
    public function getPlanPic($plan_id){
        return $this->db->order_by("id", "asc")->get_where('plan_pic',array('plan_id' => $plan_id))->result_array();
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
        $sql = " select " . $condition . " from " .$this->table ." where status=1";
       
      
        if(!empty($where['keyword'])){
            $sql .= " and plan_name like '%" . $where['keyword'] . "%' ";
        }
        //echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by create_time desc  limit {$limit},{$offset}";
            $data = $this->db->query($sql)->result_array();
           
            return $data;
        }

    }
	









    
}