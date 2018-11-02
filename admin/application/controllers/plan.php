<?php

/**
 * @desc 精练计划
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Plan extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_plan');
    }
    public  function add(){
        $type = $this->m_plan->getPlanType();
        $this->load->view("plan/add",compact("type"));
    }
    //添加\修改
    public function addAction(){
        $data = $_POST;
        $planPic = $data['planPic'];
        
        unset($data['planPic']);
        if(isset($data['plan_id']) && !empty($data['plan_id'])) {//修改
            $info = $this->m_plan->getRow(array('plan_id'=>$data['plan_id']));

            
            // $data['plan_pic'] = dealPic($data['plan_pic'],'s');
            

            $plan_id = $data['plan_id'];
            
            unset($data['plan_id']);
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $this->m_plan->update(array('plan_id' => $plan_id),$data);

            //清楚旧数据
            $this->db->where('plan_id', $plan_id);
            $this->db->delete('plan_pic');
            if (!empty($planPic)) {
                $count = count($planPic);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($planPic[$i])) {
                        $tmp = array(
                            'plan_id' => $plan_id,
                            'pic_path' => $planPic[$i],
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('plan_pic', $tmp);
                    }
                }
            }

            if($result){
                sendjson(array('status' => 1, 'msg' => "修改成功"));
            }else{
                sendjson(array('status' => 0, 'msg' => "修改失败"));
            }
        }else{
            // $data['plan_pic'] = dealPic($data['plan_pic'],'s');
            unset($data['plan_id']);
            $data['status'] = 1;
            $data['create_time'] = date("Y-m-d H:i:s");
            $plan_id = $this->m_plan->insert($data);
            if (!empty($planPic)) {
                $count = count($planPic);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($planPic[$i])) {
                        $tmp = array(
                            'plan_id' => $plan_id,
                            'pic_path' => $planPic[$i],
                            'create_time' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('plan_pic', $tmp);
                    }
                }
            }
            if ($plan_id > 0) {
                sendjson(array('status' => 1, 'msg' => "添加成功"));
            } else {
                sendjson(array('status' => 0, 'msg' => "添加失败"));
            }
        }
        
    }

    //列表
    public function index(){
        $where['keyword'] = $_REQUEST['keyword'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/plan/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_plan->getList($where, '', '',0);
        $data = $this->m_plan->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        $type = $this->m_plan->getPlanType();

        foreach ($data as $key=>$val){
            $saleNum = $this->db->query('select count(*) as count from order_plan_master where payment_state>1 and plan_id='.$val['plan_id'])->row_array();
            $data[$key]['saleNum'] = $saleNum['count'];
        }
        $this->load->view('plan/index', compact('where','type', 'data', 'pagination'));
    }
    //操作
    public function operation(){
        $id = $this->input->post("id");
        $info = $this->m_plan->getRow(array('plan_id'=>$id));

        $data['status'] = -1;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_plan->update(array('plan_id'=>$id),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function modify(){
        $id = $this->input->get_post("plan_id");
        $data= $this->m_plan->getRow(array('plan_id'=>$id));

        $type = $this->m_plan->getPlanType();
        $planPic = $this->m_plan->getPlanPic($id);
        $data['planPic'] = $planPic;
        $this->load->view("plan/modify",compact('data','type'));
    }
}
