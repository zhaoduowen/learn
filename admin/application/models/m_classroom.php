<?php

require_once APPPATH.'module/base_Model.php';
class M_classroom extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "classroom_master";
    }

    public function getTimeList(){
        return array('07:00','07:10','07:20','07:30','07:40','07:50','08:00','08:10','08:20','08:30','08:40','08:50','09:00','09:10','09:20','09:30','09:40','09:50','10:00','10:10','10:20','10:30','10:40','10:50','11:00','11:10','11:20','11:30','11:40','11:50','12:00','12:10','12:20','12:30','12:40','12:50','13:00','13:10','13:20','13:30','13:40','13:50','14:00','14:10','14:20','14:30','14:40','14:50','15:00','15:10','15:20','15:30','15:40','15:50','16:00','16:10','16:20','16:30','16:40','16:50','17:00','17:10','17:20','17:30','17:40','17:50','18:00','18:10','18:20','18:30','18:40','18:50','19:00','19:10','19:20','19:30','19:40','19:50','20:00'

,'20:10','20:20','20:30','20:40','20:50','21:00','21:10','21:20','21:30','21:40','21:50','22:00'
            );
    }
    public function getDetail($site_id){
        $classroom = $this->db->get_where('classroom_master',array('status'=>1,'site_id' => $site_id))->result_array();
        foreach ($classroom as $key => $value) {
            $timetable = $this->getTimetable($value['classroom_id']);
      
            $classroom[$key]['timetable'] = $timetable;
        }
        return $classroom;
    }
    public function getTimetable($classroom_id){
        return $this->db->get_where('classroom_timetable',array('status'=>1,'classroom_id' => $classroom_id))->result_array();
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
        $sql = " select " . $condition . " from " .$this->table ." where status=1 ";
       
     
        if(!empty($where['keyword'])){
            $sql .= " and site_name like '%" . $where['keyword'] . "%' ";
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