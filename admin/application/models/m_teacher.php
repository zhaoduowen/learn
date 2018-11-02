<?php

require_once APPPATH.'module/base_Model.php';
class M_teacher extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "teacher_master";
    }

 
    //获取场地 课程
    public function getTeacherLesson($teacher_id){
		return $this->db->get_where('teacher_lesson',array('status'=>1,'teacher_id' => $teacher_id))->result_array();
	}
   public function getTeacherSite($teacher_id){
        return $this->db->get_where('teacher_site',array('status'=>1,'teacher_id' => $teacher_id))->result_array();
    }
	
   
   
    public function getClassroomTimetable($teacher_id){
        $sql = 'select  b.site_id from teacher_timetable a 
        left join classroom_timetable b on a.timetable_id=b.timetable_id
        where a.teacher_id='.$teacher_id .' group by b.site_id';
        $data = $this->db->query($sql)->result_array();

        $site_id = array_column($data,'site_id');
        $site_id = trim(implode($site_id,','),',');
      
        $this->load->model('m_classroom');
        if (empty($site_id)) {
            return [];
        }
        $sql = "select * from site_master where site_id in ($site_id)";
        $result = $this->db->query($sql)->result_array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $classroom= $this->m_classroom->getDetail($value['site_id']);
                $result[$key]['classroom'] = $classroom;
            }
        }
        return $result;
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
            $sql .= " and teacher_name like '%" . $where['keyword'] . "%' ";
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