<?php

//首页设置
class Sethome extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_sethome');
    }
    //品牌专访列表
    public function brand_index(){
        $where['keyword'] = $_REQUEST['keyword'];
        $where['set_type'] = 1;
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/sethome/brand_index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_sethome->getList($where, '', '',0);
        $data = $this->m_sethome->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        $typeArr = $this->m_sethome->getType();
        $this->load->view('sethome/brand_index', compact('where', 'data', 'pagination','typeArr'));
    }
     //专题列表
    public function zhuanti_index(){
        $where['keyword'] = $_REQUEST['keyword'];
        $where['set_type'] = 2;
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/sethome/zhuanti_index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_sethome->getList($where, '', '',0);
        $data = $this->m_sethome->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        
        $this->load->view('sethome/zhuanti_index', compact('where', 'data', 'pagination'));
    }

    public  function brand_add(){
        
        $this->load->view("sethome/brand_add",compact());
    }
    public  function zhuanti_add(){
        
        $this->load->view("sethome/zhuanti_add",compact());
    }
    //添加\修改
    public function brandAddAction(){
        $data = $_POST;
        if(isset($data['set_id']) && !empty($data['set_id'])) {//修改
            $info = $this->m_sethome->getRow(array('set_id'=>$data['set_id']));

            $set_id = $data['set_id'];
            unset($data['set_id']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_sethome->update(array('set_id' => $set_id),$data);

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
          
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $set_id = $this->m_sethome->insert($data);
           
            if ($set_id > 0) {
                sendjson(array('status' => 1, 'msg' => "添加成功"));
            } else {
                sendjson(array('status' => 0, 'msg' => "添加失败"));
            }
        }
        
    }
    

    //操作
    public function operation(){
        $id = $this->input->post("id");
        $status = $this->input->post("status");
        $info = $this->m_sethome->getRow(array('set_id'=>$id));

        $data['status'] = $status;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_sethome->update(array('set_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("set_id");
        $data= $this->m_sethome->getRow(array('set_id'=>$id));

        $this->load->view("sethome/modify",compact('data'));
    }

    
}