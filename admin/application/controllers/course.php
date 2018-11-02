<?php

/**
 * @desc 排课
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Course extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_site');
        $this->load->model('m_course');
        $this->load->model('m_classroom');
        $this->load->model('m_classroom_timetable');
        $this->load->model('m_lesson');
        $this->load->model('m_teacher');
    }
    public  function add(){

        $site = $this->m_site->get(array('status'=>1));
        $lesson = $this->m_lesson->get(array('status'=>1));
        $this->load->view("course/add",compact("type","lesson",'site'));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        $classroom = $this->m_classroom->getRow(array('classroom_id'=>$data['classroom_id']));
        $timetable = $this->m_classroom_timetable->getRow(array('timetable_id'=>$data['timetable_id']));
        $teacher = $this->m_teacher->getRow(array('teacher_id'=>$data['teacher_id']));
        $lesson = $this->m_lesson->getRow(array('lesson_id'=>$data['lesson_id']));
        $data['classroom_name'] = $classroom['classroom_name'];
        $data['classroom_people_num'] = $data['classroom_people_num']? $data['classroom_people_num'] : $classroom['classroom_people_num'];
        $data['lesson_price'] = $data['lesson_price']? $data['lesson_price'] : $lesson['lesson_price'];
        $data['begin_time'] = $timetable['begin_time'];
        $data['end_time'] = $timetable['end_time'];
        $data['teacher_name'] = $teacher['teacher_name'];
        $data['teacher_avatar'] = $teacher['teacher_avatar'];
        $data['lesson_name'] = $lesson['lesson_name'];
        $data['lesson_type'] = $lesson['lesson_type'];
        $data['lesson_time_length'] = $lesson['lesson_time_length'];
        $data['lesson_strength'] = $lesson['lesson_strength'];
        $data['lesson_content'] = $lesson['lesson_content'];
        $data['lesson_remind'] = $lesson['lesson_remind'];
    
        $paiguo = $this->m_course->getRow(array('course_date'=>$data['course_date'],'timetable_id'=>$data['timetable_id'],'status'=>1));
        

        if(isset($data['course_id']) && !empty($data['course_id'])) {//修改
            $info = $this->m_course->getRow(array('course_id'=>$data['course_id']));
           
            $course_id = $data['course_id'];
            if($paiguo && $paiguo['course_id']!=$course_id){
                sendjson(array('status' => 0, 'msg' => "已经排过课了"));
            }
            unset($data['course_id']);

            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_course->update(array('course_id' => $course_id),$data);

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
           if($paiguo){
                sendjson(array('status' => 0, 'msg' => "已经排过课了"));
            }
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $course_id = $this->m_course->insert($data);
            
            if ($course_id > 0) {
                sendjson(array('status' => 1, 'msg' => "添加成功"));
            } else {
                sendjson(array('status' => 0, 'msg' => "添加失败"));
            }
        }
        
    }

    //列表
    public function index(){
        $where['lesson_type'] = $_REQUEST['lesson_type'];
        $where['site_id'] = $_REQUEST['site_id'];
        $where['lesson_name'] = $_REQUEST['lesson_name'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['teacher_name'] = $_REQUEST['teacher_name'];
        $where['course_date'] = $_REQUEST['course_date'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/course/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_course->getList($where, '', '',0);
        $data = $this->m_course->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();

        $lessonType = $this->m_lesson->getLessonType();
        $site = $this->m_site->get(array('status'=>1));
        
        $teacher = $this->m_teacher->get(array('status'=>1));
        $this->load->view('course/index', compact('where','site','teacher', 'lessonType','data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_course->getRow(array('course_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_course->update(array('course_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
           $referUrl = $_SERVER['HTTP_REFERER'];
        $id = $this->input->get_post("course_id");
      
        $data= $this->m_course->getRow(array('course_id'=>$id));

        $site = $this->m_site->get(array('status'=>1));
        $site_id = $data['site_id'];
        $classroom_id = $data['classroom_id'];
        $timetable_id = $data['timetable_id'];
        $teacher_id = $data['teacher_id'];
        $classroom = $this->m_site->getSiteClassroom($site_id);
        $timetable= $this->m_classroom->getTimetable($classroom_id);
        $teacher= $this->m_course->getTeacherByTimetableId($timetable_id);
        $lesson= $this->m_course->getCourseLesson($site_id,$teacher_id);
        $this->load->view("course/modify",compact('data','site','classroom','timetable','teacher','lesson','referUrl'));
    }

    //获取教室
    public function getClassroom(){
        $site_id = $this->input->get_post('site_id');
       
        $result= $this->m_site->getSiteClassroom($site_id);
        // $result= $this->m_classroom->getDetail($site_id);
        if (!empty($result)) {
            sendjson(array('status'=>'1','msg'=>'ok','result'=>$result));
        }else{
            sendjson(array('status'=>'0','msg'=>'没有找到教室','result'=>array()));
        }
    }
    //获取日期
    public function getTimetable(){
        $site_id = $this->input->get_post('site_id');
        $classroom_id = $this->input->get_post('classroom_id');
       
        $result= $this->m_classroom->getTimetable($classroom_id);
        if (!empty($result)) {
            sendjson(array('status'=>'1','msg'=>'ok','result'=>$result));
        }else{
            sendjson(array('status'=>'0','msg'=>'没有设置时间区域','result'=>array()));
        }
    }
    //选取老师
    public function getTeacher(){
        $site_id = $this->input->get_post('site_id');
        $classroom_id = $this->input->get_post('classroom_id');
        $timetable_id = $this->input->get_post('timetable_id');
       
        $result= $this->m_course->getTeacherBySiteId($site_id);
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
       
        $result= $this->m_course->getCourseLesson($site_id,$teacher_id);
        if (!empty($result)) {
            sendjson(array('status'=>'1','msg'=>'ok','result'=>$result));
        }else{
            sendjson(array('status'=>'0','msg'=>'没有找到课程','result'=>array()));
        }
    }


    //列表导出
    public function export() {
        $where['lesson_type'] = $_REQUEST['lesson_type'];
        $where['site_id'] = $_REQUEST['site_id'];
        $where['lesson_name'] = $_REQUEST['lesson_name'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['teacher_name'] = $_REQUEST['teacher_name'];
        $where['course_date'] = $_REQUEST['course_date'];
        $where['history'] = 1;
    

        $data = $this->m_course->getList($where, 0,100000,1);


        $lessonType = $this->m_lesson->getLessonType();

        $list = $this->m_course->getList($where, 0, 100000,1);



        $dataInfo = array();
        foreach ($list as $key => $item) {

            $data = array();
            $data['v1'] = $item['course_date'];
            $data['v2'] = $item['site_name'];
            $data['v3'] = $item['classroom_name'];
            $data['v4'] = $lessonType[$item['lesson_type']];
            $data['v5'] = $item['begin_time'].'-'.$item['end_time'];
            $data['v6'] =  $item['lesson_name'];

            $data['v7'] = $item['lesson_price'];
            $data['v8'] = $item['teacher_name'];
            $data['v9'] = $item['appoint_people_num'].'('.$item['classroom_people_num'].')';

            $dataInfo[] = $data;
        }
        //print_r($dataInfo);die;
        $title = array(
            '日期',
            '场地',
            '教室',
            '课程类型',
            '时间区域',
            '课程',
            '价格',
            '老师',
            '约课人数',

        );
        $fileName = "固定排课历史记录列表" . '.csv';

        if (is_array($title)) {
            $title = join(",", $title) . "\r\n";
        }

        $content = "";
        //print_r($dataInfo);die;
        if (is_array($dataInfo)) {
            foreach ($dataInfo as $v) {
                $content .= join(",", $v) . "\r\n";
            }
        }
        $content = $title . $content;
        $content = mb_convert_encoding($content, 'GBK', 'UTF-8');

        $filesize = strlen($content);
        if(preg_match( '/MSIE/i', $_SERVER['HTTP_USER_AGENT'] )||preg_match( '/Edge/i', $_SERVER['HTTP_USER_AGENT'] )){
            $fileName = urlencode($fileName);
            $fileName = iconv('UTF-8', 'GBK//IGNORE', $fileName);
        }
        @header("Content-Type:application/x-msdownload");
        @header("Content-Disposition:" . (strstr($_SERVER[HTTP_USER_AGENT], "MSIE") ? "" : "attachment;") . "filename=$fileName");
        @header("Content-Length:$filesize");
        echo $content;
        exit;
    }





}
