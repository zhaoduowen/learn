<?php

/**
 * @desc 课程
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Lesson extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_site');
        $this->load->model('m_lesson');
    }
    public  function add(){
        $type = $this->m_lesson->getLessonType();
        $this->load->view("lesson/add",compact("type"));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        $lessonPic = $data['lessonPic'];
        unset($data['lessonPic']);
        if(isset($data['lesson_id']) && !empty($data['lesson_id'])) {//修改
            $info = $this->m_lesson->getRow(array('lesson_id'=>$data['lesson_id']));

            if(isset($lessonPic[0])){
                $data['lesson_pic'] = $this->dealPic($lessonPic[0],'s');
            }

            $lesson_id = $data['lesson_id'];
            
            unset($data['lesson_id']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_lesson->update(array('lesson_id' => $lesson_id),$data);

            //清楚旧数据
            $this->db->where('lesson_id', $lesson_id);
            $this->db->delete('lesson_pic');
            if (!empty($lessonPic)) {
                $count = count($lessonPic);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lessonPic[$i])) {
                        $tmp = array(
                            'lesson_id' => $lesson_id,
                            'pic_path' => $lessonPic[$i],
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('lesson_pic', $tmp);
                    }
                }
            }

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
            if(isset($lessonPic[0])){
                $data['lesson_pic'] = $this->dealPic($lessonPic[0],'s');
            }
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $lesson_id = $this->m_lesson->insert($data);
            if (!empty($lessonPic)) {
                $count = count($lessonPic);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lessonPic[$i])) {
                        $tmp = array(
                            'lesson_id' => $lesson_id,
                            'pic_path' => $lessonPic[$i],
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('lesson_pic', $tmp);
                    }
                }
            }
            if ($lesson_id > 0) {
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
        $pageUrl = site_url('/lesson/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_lesson->getList($where, '', '',0);
        $data = $this->m_lesson->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        $type = $this->m_lesson->getLessonType();
        $this->load->view('lesson/index', compact('where','type', 'data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_lesson->getRow(array('lesson_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_lesson->update(array('lesson_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("lesson_id");
        $data= $this->m_lesson->getRow(array('lesson_id'=>$id));

        $type = $this->m_lesson->getLessonType();
        $lessonPic = $this->m_lesson->getLessonPic($id);
        $data['lessonPic'] = $lessonPic;
        $this->load->view("lesson/modify",compact('data','type'));
    }
}