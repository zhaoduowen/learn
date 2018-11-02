<?php

/**
 * @desc 给老师排课排课
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class TeacherCourse extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_site');
        $this->load->model('m_teacher_course');
        $this->load->model('m_classroom');
        $this->load->model('m_classroom_timetable');
        $this->load->model('m_lesson');
        $this->load->model('m_teacher');
    }
    public  function add(){

        $teacher = $this->m_teacher->get(array('status'=>1));
        $weekDay = $this->m_site->getWeekDay();
        // $lesson = $this->m_lesson->get(array('status'=>1));
        $this->load->view("teacher_course/add",compact("type",'teacher','weekDay'));
    }
    //添加\修改
    public function modifyAction(){
        $data = $_POST;
        $classroom = $this->m_classroom->getRow(array('classroom_id'=>$data['classroom_id']));
        $timetable = $this->m_classroom_timetable->getRow(array('timetable_id'=>$data['timetable_id']));
        $teacher = $this->m_teacher->getRow(array('teacher_id'=>$data['teacher_id']));
        $lesson = $this->m_lesson->getRow(array('lesson_id'=>$data['lesson_id']));
        $data['teacher_name'] = $teacher['teacher_name'];
        $data['classroom_name'] = $classroom['classroom_name'];
        $data['classroom_people_num'] = $data['classroom_people_num']? $data['classroom_people_num'] : $classroom['classroom_people_num'];
      
        $timetable_arr = $data['timetable_arr'];
        $timetable_begin = $data['timetable_begin'];
        $timetable_end = $data['timetable_end'];
        $teacher_id = $data['teacher_id'];
        unset($data['timetable_arr']);
        unset($data['timetable_begin']);
        unset($data['timetable_end']);
        if(isset($data['course_id']) && !empty($data['course_id'])) {//修改
            $info = $this->m_teacher_course->getRow(array('course_id'=>$data['course_id']));

            $course_id = $data['course_id'];
            
            unset($data['course_id']);

            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_teacher_course->update(array('course_id' => $course_id),$data);

            $this->db->where('course_id', $course_id);
            $this->db->delete('teacher_timetable');
            if (!empty($timetable_arr)) {
                $count = count($timetable_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($timetable_arr[$i])) {
                        $tmp = array(
                            'course_id' => $course_id,
                            'teacher_id' => $teacher_id,
                            'timetable_id' => $timetable_arr[$i],
                            'begin_time' => $timetable_begin[$i],
                            'end_time' => $timetable_end[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('teacher_timetable', $tmp);
                    }
                }
            }
            
            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }
        
    }

    public function addAction(){
        $data = $_POST;
// print_r($data);exit;
        $teacher_id = $data['teacher_id'];
        $course_date = $data['course_date'];
        // $course_date_end = $data['course_date_end'];
        $classroom_arr = $data['classroom_arr'];
        $teacher = $this->m_teacher->getRow(array('teacher_id'=>$data['teacher_id']));
        
        $insertData['teacher_name'] = $teacher['teacher_name'];
        $insertData['teacher_id'] = $teacher['teacher_id'];
        /*
        $days = 1;
        if(!empty($course_date_end)){
            $days = (strtotime($course_date_end) - strtotime($course_date))/3600/24;
        }
        $course_date_time = strtotime($course_date); 
        */
        if (empty($course_date)) {
            sendjson(array('status' => 0, 'msg' => "选择日期"));
        }
        $error = 0;
        $countDate = count($course_date);
            
        $this->db->trans_begin();
        for ($day = 0; $day < $countDate; $day++) {
                if (isset($course_date[$day])) {
                        $insertData['course_date'] = $course_date[$day];
                        $paiguo = $this->m_teacher_course->getOne(array('course_date'=>$insertData['course_date'],'teacher_id'=>$teacher_id,'status'=>1));
                        if($paiguo){
                            $this->db->trans_rollback();
                            sendjson(array('status' => 0, 'msg' => $insertData['course_date']."已经排过课了"));

                        }

                        if (!empty($classroom_arr)) {
                            $count = count($classroom_arr);
                            for ($i = 0; $i < $count; $i++) {
                                if (isset($classroom_arr[$i])) {
                                    $classroom_id = $classroom_arr[$i][0];
                                    $timetable_arr = $classroom_arr[$i][1];
                                    //根据时间段id获取场地信息
                                    $classroom = $this->m_classroom->getRow(array('classroom_id'=>$classroom_id));
                                    $insertData['status'] = 1;
                                    $insertData['create_time'] = date("Y-m-d H:i:s");
                                    $insertData['site_id'] = $classroom['site_id'];
                                    $insertData['classroom_id'] = $classroom['classroom_id'];
                                    $insertData['classroom_name'] = $classroom['classroom_name'];
                                    $insertData['classroom_people_num'] = $classroom['classroom_people_num'];
                                    $course_id = $this->m_teacher_course->insert($insertData);
                                    if(empty($course_id)){
                                        $error = 1;
                                    }
                                    
                                    if (!empty($timetable_arr)) {
                                        $timecount = count($timetable_arr);
                                        for ($j = 0; $j < $timecount; $j++) {
                                            if (isset($timetable_arr[$j])) {
                                                $timetable_id = $timetable_arr[$j];
                                                //根据时间段id获取场地信息
                                                $timeInfo = $this->m_classroom_timetable->getRow(array('timetable_id'=>$timetable_id));
                  
                                                $tmp = array(
                                                    'course_id' => $course_id,
                                                    'teacher_id' => $teacher_id,
                                                    'timetable_id' => $timeInfo['timetable_id'],
                                                    'begin_time' => $timeInfo['begin_time'],
                                                    'end_time' =>   $timeInfo['end_time'],
                                                    'status' => 1,
                                                    'create_time' => date("Y-m-d H:i:s")
                                                );
                                                $rs = $this->db->insert('teacher_timetable', $tmp);
                                                if(empty($rs)){
                                                    $error = 1;
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                        }


                }
        }        


        if ($error == 0) {
             //事务提交
            $this->db->trans_commit();
            sendjson(array('status' => 1, 'msg' => "添加成功"));
        } else {
            $this->db->trans_rollback();
            sendjson(array('status' => 0, 'msg' => "添加失败"));
        }
       
        
    }
    //列表
    public function index(){
        $where['lesson_type'] = $_REQUEST['lesson_type'];
        $where['site_id'] = $_REQUEST['site_id'];
        $where['lesson_name'] = $_REQUEST['lesson_name'];
        $where['teacher_name'] = $_REQUEST['teacher_name'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['course_date'] = $_REQUEST['course_date'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/teacherCourse/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_teacher_course->getList($where, '', '',0);
        $data = $this->m_teacher_course->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();

        $lessonType = $this->m_lesson->getLessonType();
        $site = $this->m_site->get(array('status'=>1));
        $teacher = $this->m_teacher->get(array('status'=>1));
        $this->load->view('teacher_course/index', compact('where','site','teacher', 'lessonType','data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_teacher_course->getRow(array('course_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_teacher_course->update(array('course_id'=>$id),$data)){
             $this->db->where('course_id', $id);
            $this->db->delete('teacher_timetable');
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $referUrl = $_SERVER['HTTP_REFERER'];
        $id = $this->input->get_post("course_id");
      
        $data= $this->m_teacher_course->getRow(array('course_id'=>$id));

        $site = $this->m_site->get(array('status'=>1));
        $site_id = $data['site_id'];
        $classroom_id = $data['classroom_id'];
        $teacher_id = $data['teacher_id'];
        $classroom = $this->m_site->getSiteClassroom($site_id);
        $timetable= $this->m_classroom->getTimetable($classroom_id);
        $teacher= $this->m_teacher_course->getTeacherBySiteId($site_id);

        $hasTimetable = $this->m_teacher_course->getTimetable($id);
       
        $hasTimetable = array_column($hasTimetable,'timetable_id');

        $this->load->view("teacher_course/modify",compact(
            'data',
            'site',
            'classroom',
            'timetable',
            'teacher',
            'hasTimetable',
            'referUrl'
            // 'lesson'
        ));
    }

    //获取老师所在的场地
    public function getSite(){
        
        $teacher_id = trim($this->input->get_post('teacher_id'));
       

        $sql = "select a.* from site_master a left join teacher_site b on a.site_id=b.site_id where a.status=1 and b.teacher_id={$teacher_id}";
        $result = $this->db->query($sql)->result_array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $classroom= $this->m_classroom->getDetail($value['site_id']);
                $result[$key]['classroom'] = $classroom;
            }
        }
        if (!empty($result)) {
            sendjson(array('status'=>'1','msg'=>'ok','result'=>$result));
        }else{
            sendjson(array('status'=>'0','msg'=>'没有找到','result'=>array()));
        }
    }
  
    //选取老师
    public function getTeacher(){
        $site_id = $this->input->get_post('site_id');
        $classroom_id = $this->input->get_post('classroom_id');
        $timetable_id = $this->input->get_post('timetable_id');
       
        $result= $this->m_teacher_course->getTeacherBySiteId($site_id);
        // print_r($result);exit;
        if (!empty($result)) {
            sendjson(array('status'=>'1','msg'=>'ok','result'=>$result));
        }else{
            sendjson(array('status'=>'0','msg'=>'没有找到老师','result'=>array()));
        }
    }
     public function getLesson(){
        $site_id = $this->input->get_post('site_id');
        $classroom_id = $this->input->get_post('classroom_id');
        $timetable_id = $this->input->get_post('timetable_id');
        $teacher_id = $this->input->get_post('teacher_id');
       
        $result= $this->m_teacher_course->getCourseLesson($site_id,$teacher_id);
        if (!empty($result)) {
            sendjson(array('status'=>'1','msg'=>'ok','result'=>$result));
        }else{
            sendjson(array('status'=>'0','msg'=>'没有找到课程','result'=>array()));
        }
    }
}