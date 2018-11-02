<?php

/**
 * @desc 课程订单
 * @Author: duoduo
 * @Date:   2018/07/16 15:23
 */
class OrderPlan extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        // $this->load->model('m_site');
        // $this->load->model('m_course');
        // $this->load->model('m_classroom');
        // $this->load->model('m_classroom_timetable');
        $this->load->model('m_lesson');
        // $this->load->model('m_teacher');
        $this->load->model('m_plan');
        $this->load->model('m_order_plan');
    }


    public function index(){
        $where['lesson_type'] = $_REQUEST['lesson_type'];
        $where['payment_type'] = $_REQUEST['payment_type'];
        $where['lesson_id'] = $_REQUEST['lesson_id'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['course_date'] = $_REQUEST['course_date'];
        $where['order_sn'] = $_REQUEST['order_sn'];
        $where['startDate'] = $_REQUEST['startDate'];
        $where['endDate'] = $_REQUEST['endDate'];
        $where['payment_state'] = $_REQUEST['payment_state'];
        $where['plan_type'] = $_REQUEST['plan_type'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/orderPlan/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_order_plan->getList($where, '', '',0);
        $data = $this->m_order_plan->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();

        $lessonType = $this->m_lesson->getLessonType();
        $planType = $this->m_plan->getPlanType();
        $status = $this->m_order_plan->getOrderStatus();
        $paymentType = $this->m_order_plan->getPaymentType();
        $this->load->view('order_plan/index', compact('where','status','paymentType', 'planType','data', 'pagination'));
    }

    //列表导出
    public function exportOrderPlan() {
        $where['lesson_type'] = $_REQUEST['lesson_type'];
        $where['payment_type'] = $_REQUEST['payment_type'];
        $where['lesson_id'] = $_REQUEST['lesson_id'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['course_date'] = $_REQUEST['course_date'];
        $where['order_sn'] = $_REQUEST['order_sn'];
        $where['startDate'] = $_REQUEST['startDate'];
        $where['endDate'] = $_REQUEST['endDate'];
        $where['payment_state'] = $_REQUEST['payment_state'];
        $where['plan_type'] = $_REQUEST['plan_type'];
        $list = $this->m_order_plan->getList($where, 0, 100000,1);
         
        $lessonType = $this->m_lesson->getLessonType();
        $planType = $this->m_plan->getPlanType();
        $status = $this->m_order_plan->getOrderStatus();
        $paymentType = $this->m_order_plan->getPaymentType();

        foreach ($list as $key => $val) {
            $data['v1'] = $val['order_sn'];
            $data['v2'] = $val['nickname'];
            $data['v3'] = $val['mobile'];
            $data['v4'] = $val['plan_name'];
            $data['v5'] = $planType[$val['plan_type']];
            $data['v6'] = $val['total_price'];
            $data['v7'] = $val['deduction_price'];
            $data['v8'] = $val['actual_price'];
            $data['v9'] = $val['create_time'];
           
            $data['v10'] = $status[$val['payment_state']];
            $dataInfo[] = $data;
        }
        //print_r($dataInfo);die;
        $title = array(
            '订单号',
            '昵称',
            '手机号',
            '计划名称',
            '计划权益',
            
            '销售价',
            '优惠',
            '实付',
            '时间',
            
            '状态',
        );
        $fileName = "订单列表" . '.csv';

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