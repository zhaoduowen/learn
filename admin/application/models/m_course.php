<?php

require_once APPPATH.'module/base_Model.php';
class M_course extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "course_master";
    }

   

      public function  getTeacherBySiteId($site_id){
        $sql = 'select  b.* from teacher_site a 
        left join teacher_master b on a.teacher_id=b.teacher_id
        where b.status=1 and a.site_id='.$site_id;
       
        $data = $this->db->query($sql)->result_array();

        return $data;
    }
 //根据排课时间获取老师
    public function  getTeacherByTimetableId($timetable_id){
        $sql = 'select  b.* from teacher_timetable a 
        left join teacher_master b on a.teacher_id=b.teacher_id
        where b.status=1 and a.timetable_id='.$timetable_id .' group by b.teacher_id';
       
        $data = $this->db->query($sql)->result_array();

        return $data;
    }

    //排课时 根据场地课程 和老师课程， 筛选出可选课程的交集
    public function  getCourseLesson($site_id,$teacher_id){
        $sql = 'select DISTINCT(a.lesson_id),c.* from teacher_lesson a 
        inner join site_lesson b on a.lesson_id=b.lesson_id
                LEFT JOIN lesson_master c on a.lesson_id=c.lesson_id
        where a.teacher_id='.$teacher_id.' and b.site_id='.$site_id .' and c.lesson_type=1';
 
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    //列表
  
    public function getList($where = array(), $limit = '', $offset = '', $type = 0)
    {
        if ($type == 0) {
            $condition = " count(*) as count ";
        }
        if ($type == 1) {
            $condition = "a.*,b.site_name";
        }
        $date = date("Y-m-d");
        $sql = " select " . $condition . " from course_master a 
            left join site_master b on a.site_id=b.site_id
             where a.status=1 and a.course_date>='{$date}' ";

        if ($where['history']==1){
            $start =  date('Y-m-01', strtotime('-1 month'));
            $end =  date('Y-m-t', strtotime('-1 month'));
            $sql = " select " . $condition . " from course_master a 
            left join site_master b on a.site_id=b.site_id
             where a.status=1 and a.course_date>='{$start}' and a.course_date<='{$end}' ";
        }
        
        if(!empty($where['site_id'])){
            $sql .= " and a.site_id = ".$where['site_id'];
        }
        if(!empty($where['course_date'])){
            $sql .= " and a.course_date = '" .$where['course_date']."'";
        }
        if(!empty($where['lesson_type'])){
            $sql .= " and a.lesson_type = ".$where['lesson_type'];
        }
        if($where['teacher_name'] != ''){
            $sql .= " and a.teacher_name = '" .$where['teacher_name']."'";
        }
        if($where['teacher_id'] != ''){
            $sql .= " and a.teacher_id = '" .$where['teacher_id']."'";
        }
        if($where['lesson_name'] != ''){
            $sql .= " and a.lesson_name = '" .$where['lesson_name']."'";
        }
        
        // echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by  a.course_date asc,a.begin_time asc  limit {$limit},{$offset}";
            $data = $this->db->query($sql)->result_array();
           
            return $data;
        }

    }
    









    
}