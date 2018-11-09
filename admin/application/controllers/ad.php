<?php

/**
 * @desc 广告
 * @Author: duoduo
 * @Date:   2018/11/08 14:50
 */
class Ad extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_ad');
    }
    public  function add(){
        $positionArr = $this->m_ad->getPosition();
        $this->load->view("ad/add",compact("positionArr"));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        $adPic = $data['adPic'];
        unset($data['adPic']);
        if(isset($data['ad_id']) && !empty($data['ad_id'])) {//修改
            $info = $this->m_ad->getRow(array('ad_id'=>$data['ad_id']));

            if(isset($adPic[0])){
                $data['ad_pic'] = dealPic($adPic[0],'s');
            }

            $ad_id = $data['ad_id'];
            
            unset($data['ad_id']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_ad->update(array('ad_id' => $ad_id),$data);

            //清楚旧数据
            // $this->db->where('ad_id', $ad_id);
            // $this->db->delete('ad_pic');
            // if (!empty($adPic)) {
            //     $count = count($adPic);
            //     for ($i = 0; $i < $count; $i++) {
            //         if (isset($adPic[$i])) {
            //             $tmp = array(
            //                 'ad_id' => $ad_id,
            //                 'pic_path' => $adPic[$i],
            //                 'create_time' => date("Y-m-d H:i:s")
            //             );
            //             $this->db->insert('ad_pic', $tmp);
            //         }
            //     }
            // }

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
            if(isset($adPic[0])){
                $data['ad_pic'] = dealPic($adPic[0],'s');
            }
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $ad_id = $this->m_ad->insert($data);
            // if (!empty($adPic)) {
            //     $count = count($adPic);
            //     for ($i = 0; $i < $count; $i++) {
            //         if (isset($adPic[$i])) {
            //             $tmp = array(
            //                 'ad_id' => $ad_id,
            //                 'pic_path' => $adPic[$i],
            //                 'create_time' => date("Y-m-d H:i:s")
            //             );
            //             $this->db->insert('ad_pic', $tmp);
            //         }
            //     }
            // }
            if ($ad_id > 0) {
                sendjson(array('status' => 1, 'msg' => "添加成功"));
            } else {
                sendjson(array('status' => 0, 'msg' => "添加失败"));
            }
        }
        
    }

    //列表
    public function index(){
        $where['keyword'] = $_REQUEST['keyword'];
        $where['postion_id'] = $_REQUEST['postion_id'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/ad/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_ad->getList($where, '', '',0);
        $data = $this->m_ad->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        $positionArr = $this->m_ad->getPosition();
        $this->load->view('ad/index', compact('where','positionArr', 'data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_ad->getRow(array('ad_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_ad->update(array('ad_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("ad_id");
        $data= $this->m_ad->getRow(array('ad_id'=>$id));

        $positionArr = $this->m_ad->getPosition();
        // $adPic = $this->m_ad->getAdPic($id);
        // $data['adPic'] = $adPic;
        $this->load->view("ad/modify",compact('data','positionArr'));
    }
}