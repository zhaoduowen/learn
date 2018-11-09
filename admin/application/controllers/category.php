<?php

class Category extends MY_Controller {

	const PAGE_SIZE = 10;
    private $classStatus;
    private $fundProductStatus;
	public function __construct(){
        parent::__construct() ;
        $this->load->model('m_category');
        //status 0无效 1有效 -1 删除
        $this->classStatus = array(
                '-1' => '已删除', 
                '0' => '停售', 
                '1' => '在售', 
                );
    }


    public function index() {

      
        $request = array();
     
        $request['page'] = '';
        $pageUrl = site_url('/category/index') . '?' . http_build_query($request);
        $pageIndex = (int) $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $pagesize = (int) $_REQUEST['pagesize'];
        $condition = " 1 ";
//        $condition = " and status > '-1' ";
    
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit  = self::PAGE_SIZE;
        
        $sql = "SELECT * FROM category where ".$condition." order by create_time desc limit $offset,$limit";
        $list = $this->db->query($sql)->result_array();
        
        $tsql = "SELECT count(*) as count FROM category where ".$condition;
        $row = $this->db->query($tsql)->row_array();
        $total =  $row['count'];
        
       
        $bpage = new BPage(self::PAGE_SIZE, $total, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();

        $classStatus = $this->classStatus;

        $this->load->view('category/index', compact('list', 'pagination', 'request', 'classStatus'));
    }


     public  function add(){
        $type = $this->m_category->getSiteType();
        $site = $this->m_category->get(array('status'=>1));
       
        $this->load->view("category/add",compact("type","lesson",'site','newLesson','lessonType'));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        $lesson_arr = $data['lesson_arr'];
        $change_site_arr = $data['change_site_arr'];
        unset($data['lesson_arr']);
        unset($data['change_site_arr']);
        if(isset($data['category_id']) && !empty($data['category_id'])) {//修改
            $info = $this->m_category->getRow(array('category_id'=>$data['category_id']));

            // if($data['categoryPic'] != $info['category_image']){
            //     $data['category_image'] = $this->dealPic($data['categoryPic'],'s');
            // }

            $category_id = $data['category_id'];
            
            unset($data['category_id']);
            unset($data['categoryPic']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_category->update(array('category_id' => $category_id),$data);

            //清楚旧数据
            $this->db->where('category_id', $category_id);
            $this->db->delete('category_lesson');
            if (!empty($lesson_arr)) {
                $count = count($lesson_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lesson_arr[$i])) {
                        $tmp = array(
                            'category_id' => $category_id,
                            'lesson_id' => $lesson_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('category_lesson', $tmp);
                    }
                }
            }
            $this->db->where('category_id', $category_id);
            $this->db->delete('category_site');
            if (!empty($change_site_arr)) {
                $count = count($change_site_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($change_site_arr[$i])) {
                        $tmp = array(
                            'category_id' => $category_id,
                            'site_id' => $change_site_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('category_site', $tmp);
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
            $category_id = $this->m_category->insert($data);
             if (!empty($lesson_arr)) {
                $count = count($lesson_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($lesson_arr[$i])) {
                        $tmp = array(
                            'category_id' => $category_id,
                            'lesson_id' => $lesson_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('category_lesson', $tmp);
                    }
                }
            }
            $this->db->where('category_id', $category_id);
            $this->db->delete('category_site');
            if (!empty($change_site_arr)) {
                $count = count($change_site_arr);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($change_site_arr[$i])) {
                        $tmp = array(
                            'category_id' => $category_id,
                            'site_id' => $change_site_arr[$i],
                            'status' => 1,
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('category_site', $tmp);
                    }
                }
            }
            if ($category_id > 0) {
                sendjson(array('status' => 1, 'msg' => "添加成功"));
            } else {
                sendjson(array('status' => 0, 'msg' => "添加失败"));
            }
        }
        
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_category->getRow(array('category_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_category->update(array('category_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("category_id");
        $data= $this->m_category->getRow(array('category_id'=>$id));

        $site = $this->m_category->get(array('status'=>1));
        $lesson = $this->m_lesson->get(array('status'=>1));
        $newLesson = array();
        if($lesson){
         
            foreach ($lesson as $key => $value) {

                $newLesson[$value['lesson_type']][] = $value; 
            }
        
          
        }
        $hasLesson = $this->m_category->getcategoryLesson($id);
        $hasSite = $this->m_category->getcategorySite($id);
        // $classroomTimetable = $this->m_category->getClassroomTimetable($id);
        $hasLesson = array_column($hasLesson,'lesson_id');
        $hasSite = array_column($hasSite,'site_id');
        // print_r($classroomTimetable);exit;
        $lessonType = $this->m_lesson->getLessonType();
        $this->load->view("category/modify",compact('data','site','lessonType','lesson','newLesson','hasLesson','hasSite'));
    }
}

?>
