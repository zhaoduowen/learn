<?php

require_once APPPATH.'module/base_Model.php';
class M_sethome extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "set_home";
    }

  public function getType(){
        return [''];
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
       
       
       if($where['set_type'] != ''){
            $sql .= " and set_type = '" .$where['set_type']."'";
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