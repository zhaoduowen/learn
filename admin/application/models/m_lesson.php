<?php

require_once APPPATH.'module/base_Model.php';
class M_lesson extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "lesson_master";
    }

    public function getLessonType(){
        return array(
            '1' => '精品小班课',
            '2' => '私教课',
            '3' => '伙伴课',
        );
    }
    public function getLessonPic($lesson_id){
        return $this->db->order_by("ordern", "asc")->get_where('lesson_pic',array('lesson_id' => $lesson_id))->result_array();
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
            $sql .= " and lesson_name like '%" . $where['keyword'] . "%' ";
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