<?php

/**
 * @desc 教室
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Classroom extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_site');
        $this->load->model('m_classroom');
    }
    public  function add(){
        $site_id = $this->input->get_post("site_id");
        $site = $this->m_site->getRow(array('site_id'=>$site_id));
        $timeList = $this->m_classroom->getTimeList();
        $this->load->view("classroom/add",compact("site",'timeList'));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        $time_arr = $data['time_arr'];
        unset($data['time_arr']);
        if(isset($data['classroom_id']) && !empty($data['classroom_id'])) {//修改
            $info = $this->m_classroom->getRow(array('classroom_id'=>$data['site_id']));

           

            $classroom_id = $data['classroom_id'];
            
            unset($data['classroom_id']);
            
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_classroom->update(array('classroom_id' => $classroom_id),$data);

            //清楚旧数据
            $this->db->where('classroom_id', $classroom_id);
            $this->db->delete('classroom_timetable');
            if (!empty($time_arr)) {
                
                foreach ($time_arr as $key => $value) {
                      $tmp = array(
                            'site_id' => $data['site_id'],
                            'classroom_id' => $classroom_id,
                            'begin_time' => $value[0],
                            'end_time' => $value[1],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );

                        $this->db->insert('classroom_timetable', $tmp);
                }
                
            }

//             $updateSql = "UPDATE teacher_timetable a,classroom_timetable b,teacher_course_master c set a.timetable_id=b.timetable_id 
// where a.begin_time=b.begin_time and a.end_time=b.end_time and a.course_id=c.course_id and b.classroom_id=c.classroom_id";
//             $this->db->query($updateSql);
            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $classroom_id = $this->m_classroom->insert($data);
             if (!empty($time_arr)) {
                foreach ($time_arr as $key => $value) {
                      $tmp = array(
                            'site_id' => $data['site_id'],
                            'classroom_id' => $classroom_id,
                            'begin_time' => $value[0],
                            'end_time' => $value[1],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );

                        $this->db->insert('classroom_timetable', $tmp);
                }
            }
            if ($classroom_id > 0) {
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
        $pageUrl = site_url('/classroom/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_classroom->getList($where, '', '',0);
        $data = $this->m_classroom->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        
        $this->load->view('classroom/index', compact('where', 'data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_classroom->getRow(array('classroom_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_classroom->update(array('classroom_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $classroom_id = $this->input->get_post("id");
        $data= $this->m_classroom->getRow(array('classroom_id'=>$classroom_id));
        $site= $this->m_site->getRow(array('site_id'=>$data['site_id']));
        $time_arr = $this->m_classroom->getTimetable($classroom_id);
         $timeList = $this->m_classroom->getTimeList();
        $this->load->view("classroom/modify",compact('data','site','time_arr','timeList'));
    }
}