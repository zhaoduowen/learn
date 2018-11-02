<?php

require_once APPPATH.'module/base_Model.php';
class M_user_plan extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "user_plan";
    }

   

	//列表
    public function getList($where = array(), $type = 0)
    {
        if ($type == 0) {
            $condition = " count(*) as count ";
        }
        if ($type == 1) {
            $condition = " * ";
        }
        $sql = " select " . $condition . " from " .$this->table ." where status=1";
       
      
         if($where['uid'] != ''){
            $sql .= " and uid = '" .$where['uid']."'";
        }
        //echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by create_time desc";
            $data = $this->db->query($sql)->result_array();
           
            return $data;
        }

    }
	









    
}