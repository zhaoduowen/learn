<?php

/**
 * @desc 场地
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Site extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_site');
        $this->load->model('m_lesson');
    }
    public  function add(){
        $type = $this->m_site->getSiteType();
        $lesson = $this->m_lesson->get(array('status'=>1));
        $lessonType = $this->m_lesson->getLessonType();
        $newLesson = array();
        if($lesson){
         
            foreach ($lesson as $key => $value) {

                $newLesson[$value['lesson_type']][] = $value; 
            }
        
          
        }
       
        $this->load->view("site/add",compact("type","lesson",'site','newLesson','lessonType'));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        $lesson_arr = $data['lesson_arr'];
        if(isset($data['site_id']) && !empty($data['site_id'])) {//修改
            $info = $this->m_site->getRow(array('site_id'=>$data['site_id']));

            if($data['sitePic'] != $info['site_image']){
                $data['site_image'] = $this->dealPic($data['sitePic'],'s');
            }

            $site_id = $data['site_id'];
            
            unset($data['site_id']);
            unset($data['sitePic']);
            unset($data['lesson_arr']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_site->update(array('site_id' => $site_id),$data);

            //清楚旧数据
            $this->db->where('site_id', $site_id);
            $this->db->delete('site_lesson');
            if (!empty($lesson_arr)) {
                $count = count($lesson_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lesson_arr[$i])) {
                        $tmp = array(
                            'site_id' => $site_id,
                            'lesson_id' => $lesson_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('site_lesson', $tmp);
                    }
                }
            }

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
            $data['site_image'] = $this->dealPic($data['sitePic'],'s');
            unset($data['sitePic']);
            unset($data['lesson_arr']);
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $site_id = $this->m_site->insert($data);
             if (!empty($lesson_arr)) {
                $count = count($lesson_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lesson_arr[$i])) {
                        $tmp = array(
                            'site_id' => $site_id,
                            'lesson_id' => $lesson_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('site_lesson', $tmp);
                    }
                }
            }
            if ($site_id > 0) {
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
        $pageUrl = site_url('/site/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_site->getList($where, '', '',0);
        $data = $this->m_site->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        
        $this->load->view('site/index', compact('where', 'data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_site->getRow(array('site_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_site->update(array('site_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("site_id");
        $data= $this->m_site->getRow(array('site_id'=>$id));

        $type = $this->m_site->getSiteType();
        $lessonType = $this->m_lesson->getLessonType();
        $lesson = $this->m_lesson->get(array('status'=>1));
        $newLesson = array();
        if($lesson){
         
            foreach ($lesson as $key => $value) {

                $newLesson[$value['lesson_type']][] = $value; 
            }
        
          
        }
        $hasLesson = $this->m_site->getSiteLesson($id);
        $hasLesson = array_column($hasLesson,'lesson_id');

        $this->load->view("site/modify",compact('data','type','lesson','hasLesson','newLesson','lessonType'));
    }

    
}