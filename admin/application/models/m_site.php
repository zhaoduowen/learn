<?php

require_once APPPATH.'module/base_Model.php';
class M_site extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "site_master";
    }

    public function getSiteType(){
    	return array(
            '1' => '高温',
            '2' => '空中',
            '3' => '理疗',
            '4' => '常规',
        );
    }

    public function getWeekDay(){
        $weekarray=array("日","一","二","三","四","五","六");
        $day = [];
        for ($i = 0; $i <11; $i ++ ) {

            $day[$i]['date'] = date('n.j',strtotime('+'.$i .'days'));
            $day[$i]['d'] = date('Y-m-d',strtotime('+'.$i .'days'));
            if($i==0){
                 $day[$i]['week'] = '今天';
            }else{
                $day[$i]['week'] = "周".$weekarray[date("w",strtotime('+'.$i.' days'))];
            }
            
        }
        return $day;
    }
    //获取场地 课程
    public function getSiteLesson($site_id){
		return $this->db->get_where('site_lesson',array('status'=>1,'site_id' => $site_id))->result_array();
	}

	//获取场地 的教室
	public function getSiteClassroom($site_id){
		return $this->db->get_where('classroom_master',array('status'=>1,'site_id' => $site_id))->result_array();
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
            foreach ($data as $key => $value) {
            	$data[$key]['classroom'] = $this->getSiteClassroom($value['site_id']);
            }
            return $data;
        }

    }
	









    
}