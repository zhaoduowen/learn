<?php

/**
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Infomation extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_infomation');
    }
    public  function index(){
        $type = $this->m_infomation->infomationType();
        $this->load->view("infomation/add",compact("type"));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        
        if($data['web_infomation_type']-1 < 0){
            $data['web_infomation_type'] = 0;
        }else{
            $data['web_infomation_type'] = $data['web_infomation_type'] - 1;
        }
        if(isset($data['web_infomation_id']) && !empty($data['web_infomation_id'])) {//修改
            $info = $this->m_infomation->selectInfomation(array('web_infomation_id'=>$data['web_infomation_id']));
            if($data['infomationPic'] != $info['thumb_img_url']){
                $data['thumb_img_url'] = $this->dealPic($data['infomationPic'],'s');
            }
        }else{
            $data['thumb_img_url'] = $this->dealPic($data['infomationPic'],'s');
        }
        unset($data['infomationPic']);
        if(isset($data['web_infomation_id']) && !empty($data['web_infomation_id'])){//修改
            $web_infomation_id = $data['web_infomation_id'];
            unset($data['web_infomation_id']);
           
            // $data['update_admin_id'] = $this->loginUid;
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_infomation->updateInfomation(array('web_infomation_id' => $web_infomation_id),$data);
            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else {//添加
           
            // $data['create_admin_id'] = $this->loginUid;
            $data['create_time'] = date("Y-m-d H:i:s");
            $id = $this->m_infomation->addInfomation($data);
            if ($id > 0) {
                $this->m_infomation->updateInfomation(array('web_infomation_id' => $id), array('static_url' => "infomation/id/" . $id,  'update_time' => date("Y-m-d H:i:s")));
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
    public function listAction(){
        $where['keyword'] = $_REQUEST['keyword'];
        $where['type'] = $_REQUEST['type'];
        $where['is_recommend'] = $_REQUEST['is_recommend'];
        $where['startDate'] = $_REQUEST['startDate'];
        $where['endDate'] = $_REQUEST['endDate'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/infomation/listAction') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_infomation->infomation($where, '', '',0);
        $data = $this->m_infomation->infomation($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        $type = $this->m_infomation->infomationType();
        $setType = array();
        foreach($type as $key=>$val){
            $setType[$val['web_infomation_type']]  = $val['description'];
        }
        $this->load->view('infomation/list', compact('where', 'data', 'pagination','type','setType'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $type = $this->input->post("type");
        $data['update_time'] =  date("Y-m-d H:i:s");
        if($type == 1){
            $data['status'] = -1;//下线
            $data['description'] = "下线咨询";//下线
        } if($type == 2){
            $data['status'] = 1;//下线
            $data['description'] = "上线咨询";


        } if($type == 3){
            $data['delete_flag'] = 1;//删除
            $data['status'] = -1;//下线
            $data['description'] = "删除咨询";
        }
        if($this->m_infomation->updateInfomation(array('web_infomation_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("id");
        $data= $this->m_infomation->selectInfomation(array('web_infomation_id'=>$id));
        $type = $this->m_infomation->infomationType();
        //print_r($data);die;
        $this->load->view("infomation/modify",compact('data','type'));
    }
}