<?php

/**
 * @desc 活动
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Activity extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_bonus_master');
        $this->load->model('m_user_master');
    }
    public  function add(){
        $type = $this->m_bonus_master->getBonusType();
        $category = $this->m_bonus_master->getBonusCategory();
        $this->load->view("activity/add",compact("type",'category'));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        if(isset($data['bonus_id']) && !empty($data['bonus_id'])) {//修改
            $info = $this->m_bonus_master->getRow(array('bonus_id'=>$data['bonus_id']));
            $bonus_id = $data['bonus_id'];
            
            unset($data['bonus_id']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_bonus_master->update(array('bonus_id' => $bonus_id),$data);

           

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
            
            $data['create_time'] = date("Y-m-d H:i:s");
            $data['admin_id'] = $this->loginUser['id'];
            $data['admin_name'] = $this->loginUser['mobile'];
            $bonus_id = $this->m_bonus_master->insert($data);
           
            if ($bonus_id > 0) {
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
        $where['type'] = $_REQUEST['type'];
        $where['category'] = $_REQUEST['category'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/bonus/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_bonus_master->getList($where, '', '',0);
        $data = $this->m_bonus_master->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        
        $type = $this->m_bonus_master->getBonusType();
        $category = $this->m_bonus_master->getBonusCategory();
        $this->load->view('activity/index', compact('where', 'data', 'pagination','type','category'));
    }
    //发放列表
    public function sendlist(){
        $where['param'] = $_REQUEST['param'];
        $where['mobile'] = $_REQUEST['keyword'];
        $where['type'] = $_REQUEST['type'];
        $where['category'] = $_REQUEST['category'];
        $where['status'] = '';
        $where['bonus_id'] = $_REQUEST['bonus_id'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/bonus/sendlist') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_bonus_master->getBonusLogList($where, '', '',0);
        $data = $this->m_bonus_master->getBonusLogList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        
        $type = $this->m_bonus_master->getBonusType();
        $category = $this->m_bonus_master->getBonusCategory();
        $this->load->view('bonus/send_list', compact('where', 'data', 'pagination','type','category'));
    }
    //已用列表
    public function uselist(){
        $where['mobile'] = $_REQUEST['keyword'];
        $where['type'] = $_REQUEST['type'];
        $where['category'] = $_REQUEST['category'];
        $where['bonus_id'] = $_REQUEST['bonus_id'];
        $where['status'] = '2';
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/bonus/uselist') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_bonus_master->getBonusLogList($where, '', '',0);
        $data = $this->m_bonus_master->getBonusLogList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        
        $type = $this->m_bonus_master->getBonusType();
        $category = $this->m_bonus_master->getBonusCategory();
        $this->load->view('bonus/use_list', compact('where', 'data', 'pagination','type','category'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_bonus_master->getRow(array('bonus_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_bonus_master->update(array('bonus_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
        public function handle(){
        $id = $this->input->post("id");
        $status = $this->input->post("status");
        $info = $this->m_bonus_master->getRow(array('bonus_id'=>$id));

        $data['status'] = $status;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_bonus_master->update(array('bonus_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("bonus_id");
        $data= $this->m_bonus_master->getRow(array('bonus_id'=>$id));
        $type = $this->m_bonus_master->getBonusType();
        $category = $this->m_bonus_master->getBonusCategory();

        $this->load->view("bonus/modify",compact('data','type','category'));
    }


    //发放优惠券
    public function send(){
        $sendMobile = $this->input->post("sendMobile");
        $id = $this->input->get_post("bonus_id");
        $data= $this->m_bonus_master->getRow(array('bonus_id'=>$id));
        $user = $this->m_user_master->getRow(array('mobile'=>$sendMobile));
        if (empty($user)) {
            sendjson(array('status'=>0,'msg'=>"手机号不存在"));
        }
        $tmp = array(
            'bonus_id' => $id,
            'uid' => $user['uid'],
            'status'=>1,
            'create_time' => date("Y-m-d H:i:s"),
            'begin_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d",strtotime("+{$data['term_days']} days")),
        );
        $rs = $this->db->insert('bonus_give_log', $tmp);
        
        if($rs){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
   
//批量发放优惠券
    public function sendBatch(){
        require_once APPPATH.'third_party/PHPExcel/PHPExcel.php';
        require_once APPPATH.'third_party/PHPExcel/PHPExcel/IOFactory.php';
        require_once APPPATH.'third_party/PHPExcel/PHPExcel/Cell.php';
        $fileName = $this->input->post("fileName");
        $id = $this->input->get_post("bonus_id");
         // $id = 1;
        $bonus= $this->m_bonus_master->getRow(array('bonus_id'=>$id));
        $create_time =  date("Y-m-d H:i:s");
        $begin_date =  date("Y-m-d");
        $end_date = date("Y-m-d",strtotime("+{$bonus['term_days']} days"));
    
        $file_name = G_UPLOAD.$fileName;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007'); //建立reader对象
        $objPHPExcel = $objReader->load($file_name);
        $sheet = $objPHPExcel->getSheet();
        $highestRow = $sheet->getHighestDataRow(); // 取得总行数

        $highestColumn_num = PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); //列数
        $columns = array('A');
        //$columns = PHPExcel_Cell::getColumn($highestColumn_num);
        /*
        $columns = array('A');
         
        $arr_result = array();
        $dealer_element = array();
         
        for ($j = 2; $j <= $highestRow; $j++) {
        for ($k = 0; $k < count($columns); $k++) {
            //读取单元格
            $value = $objPHPExcel->getActiveSheet()->getCell($columns[$k] . $j)->getValue();//这个就是获取每个单元格的值
         
            $value = trim($value);
            if (empty($value)) {
                 $value = NULL;
            }
            $dealer_element[$k] = $value;
            //这里可以根据要求，做一些数据的验证
        }
         
        $arr_result[$j] = $dealer_element;
        }
        echo json_encode($arr_result);
        */
      
        $batch = array();
        for ($j = 1; $j <= $highestRow; $j++) {
            //读取单元格
            $value = $objPHPExcel->getActiveSheet()->getCell($columns[0] . $j)->getValue();//这个就是获取每个单元格的值
           
            $user = $this->m_user_master->getRow(array('mobile'=>$value));
            if ($user) {
               $batch[] =  array(
                    'bonus_id' => $id,
                    'uid' => $user['uid'],
                    'status'=>1,
                    'create_time' => $create_time,
                    'begin_date' => $begin_date,
                    'end_date' => $end_date,
                );
            }
            
        }
        // print_r($batch);exit;
        if ($batch) {
            $rs = $this->db->insert_batch('bonus_give_log', $batch);
        }
       
        
        if($rs){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    
}