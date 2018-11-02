<?php

/**
 * @desc 教师
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Teacher extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_site');
        $this->load->model('m_teacher');
        $this->load->model('m_classroom');
        $this->load->model('m_lesson');
    }
    public  function add(){
        $type = $this->m_site->getSiteType();
        $site = $this->m_site->get(array('status'=>1));
        $lesson = $this->m_lesson->get(array('status'=>1));
        $lessonType = $this->m_lesson->getLessonType();
        $newLesson = array();
        if($lesson){
         
            foreach ($lesson as $key => $value) {

                $newLesson[$value['lesson_type']][] = $value; 
            }
        
          
        }
       
        $this->load->view("teacher/add",compact("type","lesson",'site','newLesson','lessonType'));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        // parse_str('teacher_name=%E9%BB%8E%E6%98%8E&sign=3232&mobile=1111&timetable_arr%5B%5D=10&timetable_arr%5B%5D=11&lesson_arr%5B%5D=2&lesson_arr%5B%5D=3&teacher_avatar=%2Fteacher%2F2018%2F07%2F11%2F7a4a95-1531311972.jpg&content=%3Cp%3E111111111%3C%2Fp%3E&remark=111111111111',$data);
        // print_r($data);exit;
        $lesson_arr = $data['lesson_arr'];
        $change_site_arr = $data['change_site_arr'];
        unset($data['lesson_arr']);
        unset($data['change_site_arr']);
        if(isset($data['teacher_id']) && !empty($data['teacher_id'])) {//修改
            $info = $this->m_teacher->getRow(array('teacher_id'=>$data['teacher_id']));

            // if($data['teacherPic'] != $info['teacher_image']){
            //     $data['teacher_image'] = $this->dealPic($data['teacherPic'],'s');
            // }

            $teacher_id = $data['teacher_id'];
            
            unset($data['teacher_id']);
            unset($data['teacherPic']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_teacher->update(array('teacher_id' => $teacher_id),$data);

            //清楚旧数据
            $this->db->where('teacher_id', $teacher_id);
            $this->db->delete('teacher_lesson');
            if (!empty($lesson_arr)) {
                $count = count($lesson_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lesson_arr[$i])) {
                        $tmp = array(
                            'teacher_id' => $teacher_id,
                            'lesson_id' => $lesson_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('teacher_lesson', $tmp);
                    }
                }
            }
            $this->db->where('teacher_id', $teacher_id);
            $this->db->delete('teacher_site');
            if (!empty($change_site_arr)) {
                $count = count($change_site_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($change_site_arr[$i])) {
                        $tmp = array(
                            'teacher_id' => $teacher_id,
                            'site_id' => $change_site_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('teacher_site', $tmp);
                    }
                }
            }

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
           
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $teacher_id = $this->m_teacher->insert($data);
             if (!empty($lesson_arr)) {
                $count = count($lesson_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lesson_arr[$i])) {
                        $tmp = array(
                            'teacher_id' => $teacher_id,
                            'lesson_id' => $lesson_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('teacher_lesson', $tmp);
                    }
                }
            }
            $this->db->where('teacher_id', $teacher_id);
            $this->db->delete('teacher_site');
            if (!empty($change_site_arr)) {
                $count = count($change_site_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($change_site_arr[$i])) {
                        $tmp = array(
                            'teacher_id' => $teacher_id,
                            'site_id' => $change_site_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('teacher_site', $tmp);
                    }
                }
            }
            if ($teacher_id > 0) {
                sendjson(array('status' => 1, 'msg' => "添加成功"));
            } else {
                sendjson(array('status' => 0, 'msg' => "添加失败"));
            }
        }
        
    }
    public static function dealPic($imageUrl,$type='') {
        $imageArr = array('s' => '', 'b' => '', 'l' => '');
        if (empty($imageUrl)) {
            return '';
        }
        $dirname = dirname($imageUrl);
        $imageName = strrchr($imageUrl, '/');
        $s_imageurl = $dirname . str_replace('/', '/s_', $imageName);
        $b_imageurl = $dirname . str_replace('/', '/b_', $imageName);
        $l_imageurl = $dirname . str_replace('/', '/l_', $imageName);
        $imageArr['s'] = $s_imageurl;
        $imageArr['b'] = $b_imageurl;
        $imageArr['l'] = $l_imageurl;
        if($type){
            return $imageArr[$type];
        }else{
            return $imageArr;
        }
    }
    //列表
    public function index(){
        $where['keyword'] = $_REQUEST['keyword'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/teacher/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_teacher->getList($where, '', '',0);
        $data = $this->m_teacher->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        
        $this->load->view('teacher/index', compact('where', 'data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_teacher->getRow(array('teacher_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_teacher->update(array('teacher_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("teacher_id");
        $data= $this->m_teacher->getRow(array('teacher_id'=>$id));

        $site = $this->m_site->get(array('status'=>1));
        $lesson = $this->m_lesson->get(array('status'=>1));
        $newLesson = array();
        if($lesson){
         
            foreach ($lesson as $key => $value) {

                $newLesson[$value['lesson_type']][] = $value; 
            }
        
          
        }
        $hasLesson = $this->m_teacher->getTeacherLesson($id);
        $hasSite = $this->m_teacher->getTeacherSite($id);
        // $classroomTimetable = $this->m_teacher->getClassroomTimetable($id);
        $hasLesson = array_column($hasLesson,'lesson_id');
        $hasSite = array_column($hasSite,'site_id');
        // print_r($classroomTimetable);exit;
        $lessonType = $this->m_lesson->getLessonType();
        $this->load->view("teacher/modify",compact('data','site','lessonType','lesson','newLesson','hasLesson','hasSite'));
    }

    public function getSite(){
        
        $site_id = trim($this->input->get_post('site_id'),',');
       

        $sql = "select * from site_master where site_id in ($site_id)";
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
}