<?php

/**
 * @desc 用户管理
 * @Author: duoduo
 * @Date:   2018/07/08 14:50
 */
class Webuser extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_user_master');
        // $this->load->model('m_order');
        $this->load->model('m_user_plan');
        $this->load->model('m_bonus_master');

    }
    
    //列表
    public function index(){
        $where['keyword'] = $_REQUEST['keyword'];
        $where['status'] = $_REQUEST['status'];

        $where['startDate'] = $_REQUEST['startDate'];
        $where['endDate'] = $_REQUEST['endDate'];
        $where['mobile'] = $_REQUEST['mobile'];
        $where['share_user_id'] = $_REQUEST['share_user_id'];

        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/webuser/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;

        $count = $this->m_user_master->getList($where, '', '',0);
        $data = $this->m_user_master->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();
        $status = $this->m_user_master->getUserStatus();
        foreach ($data as $key => $value) {
            $fisettime = $this->m_user_master->getFirstCourseTime($value['uid']);
            $data[$key]['firstCourseTime'] = $fisettime?$fisettime['course_date'].' '.$fisettime['begin_time']:'';
            $lasttime = $this->m_user_master->getLastCourse($value['uid']);
            $data[$key]['lastCourseTime'] = $lasttime?$lasttime['course_date'].' '.$lasttime['begin_time']:'';
            $sql = "select site_name ,count(site_id) counts from order_master where uid={$value['uid']} and  payment_state>1 GROUP BY site_id ORDER BY counts desc limit 1";
            $maxSite = $this->db->query($sql)->row_array();
            $data[$key]['site_name'] = $maxSite ? $maxSite['site_name'] : '';

            $invitesql = "select count(*) count from user_master where share_user_id={$value['uid']} ";
            $inviter_num = $this->db->query($invitesql)->row_array();

            $data[$key]['inviter_num'] = $inviter_num['count'];
        }
        $this->load->view('webuser/index', compact('where','status', 'data', 'pagination'));
    }
    //操作
    public function operation(){
        $uid = $this->input->post("uid");
        $status = $this->input->post("status");
        $info = $this->m_user_master->getRow(array('uid'=>$uid));

        $data['status'] = $status ;
        $data['update_time'] =  date("Y-m-d H:i:s");
        
        if($this->m_user_master->update(array('uid'=>$uid),$data)){
            sendjson(array('status'=>1,'msg'=>"操作成功"));
        }else{
            sendjson(array('status'=>0,'msg'=>"操作失败"));
        }
    }
    public function info(){
        $uid = $this->input->get_post("uid");
        $data = $this->m_user_master->getRow(array('uid'=>$uid));

        $orderCount = $this->m_user_master->getOrderCount($uid);
        $planCount = $this->m_user_plan->getList(array('uid'=>$uid),0);
        $plan = $this->m_user_plan->getList(array('uid'=>$uid),1);
        $bonusCount = $this->m_bonus_master->getBonusLogList(array('uid'=>$uid), '', '',0);
        $usebonusCount = $this->m_bonus_master->getBonusLogList(array('uid'=>$uid,'status'=>2), '', '',0);
        $bonus = $this->m_bonus_master->getBonusLogList(array('uid'=>$uid), 0, 100,1);
        $loseDay = $this->m_user_master->getLostDay($uid);
        $firstTime = $this->m_user_master->getFirstCourseTime($uid);

        

        $data['orderCount'] = $orderCount?$orderCount:0;
        $data['planCount'] = $planCount?$planCount:0;
        $data['plan'] = $plan;
        $data['bonusCount'] = $bonusCount?$bonusCount:0;
        $data['useBonusCount'] = $usebonusCount?$usebonusCount:0;
        $data['bonus'] = $bonus;
        $data['loseDay'] = $loseDay;
        $data['firstTime'] = $firstTime ? $firstTime['course_date'].' '.$firstTime['begin_time']:'';
        $status = $this->m_user_master->getUserStatus();
        
        $this->load->view("webuser/info",compact('data','status'));
    }


        //列表导出
    public function exportUser() {
        $where['keyword'] = $_REQUEST['keyword'];
        $where['status'] = $_REQUEST['status'];

        $list = $this->m_user_master->getList($where, 0, 100000,1);

        $status = $this->m_user_master->getUserStatus();
        $data = array();
        foreach ($list as $key => $val) {

            $fisettime = $this->m_user_master->getFirstCourseTime($val['uid']);
            $val['firstCourseTime'] = $fisettime?$fisettime['course_date'].' '.$fisettime['begin_time']:'';
            $lasttime = $this->m_user_master->getLastCourse($val['uid']);
            $val['lastCourseTime'] = $lasttime?$lasttime['course_date'].' '.$lasttime['begin_time']:'';
            $sql = "select site_name ,count(site_id) counts from order_master where uid={$val['uid']} and  payment_state>1 GROUP BY site_id ORDER BY counts desc limit 1";
            $maxSite = $this->db->query($sql)->row_array();
            $val['site_name'] = $maxSite ? $maxSite['site_name'] : '';
            $invitesql = "select count(*) count from user_master where share_user_id={$val['uid']} ";
            $inviter_num = $this->db->query($invitesql)->row_array();

            $inviter_num = $inviter_num['count'];
            $data['v1'] = $val['uid'];
            $data['v2'] = $val['nickname'];
            $data['v3'] = $val['mobile'];
            $data['v4'] = $val['sex']==1?'男':'女';
            $data['v5'] = $val['orderCount'];
            $data['v6'] =  date("Y-m-d",strtotime($val['create_time']));
            $data['v7'] = $val['share_user_id']>0?'转介绍':'正常注册';;
            $data['v8'] = $val['firstCourseTime'];
            $data['v9'] = $val['lastCourseTime'];
            $data['v10'] = $val['site_name'];
            $data['v11'] = $val['loseDay'];
            $data['v11'] =  $inviter_num;
            $dataInfo[] = $data;
        }
        //print_r($dataInfo);die;
        $title = array(
            '用户ID',
            '用户昵称',
            '手机号',
            '性别',
            '约课次数',
            '注册日期',
            '获取方式',
            '首次订单',
            '最后订单',
            '所属场馆',
            '流失天数',
            '邀请人数',
        );
        $fileName = "用户列表" . '.csv';

        if (is_array($title)) {
            $title = join(",", $title) . "\r\n";
        }

        $content = "";
        //print_r($dataInfo);die;
        if (is_array($dataInfo)) {
            foreach ($dataInfo as $v) {
                $content .= join(",", $v) . "\r\n";
            }
        }
        $content = $title . $content;
        $content = mb_convert_encoding($content, 'GBK', 'UTF-8');

        $filesize = strlen($content);
        if(preg_match( '/MSIE/i', $_SERVER['HTTP_USER_AGENT'] )||preg_match( '/Edge/i', $_SERVER['HTTP_USER_AGENT'] )){
            $fileName = urlencode($fileName);
            $fileName = iconv('UTF-8', 'GBK//IGNORE', $fileName);
        }
        @header("Content-Type:application/x-msdownload");
        @header("Content-Disposition:" . (strstr($_SERVER[HTTP_USER_AGENT], "MSIE") ? "" : "attachment;") . "filename=$fileName");
        @header("Content-Length:$filesize");
        echo $content;
        exit;
    }


}