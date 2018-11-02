<?php

/**
 * @desc 订单
 * @Author: duoduo
 * @Date:   2018/07/16 15:23
 */
class Order extends MY_Controller
{
    const PAGE_SIZE = 10;
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_site');
        // $this->load->model('m_course');
        // $this->load->model('m_classroom');
        // $this->load->model('m_classroom_timetable');
        $this->load->model('m_lesson');
        $this->load->model('m_teacher');
        $this->load->model('m_order');
    }


    //列表
    public function index(){
        $where['site_id'] = $_REQUEST['site_id'];
        $where['lesson_type'] = $_REQUEST['lesson_type'];
        $where['payment_type'] = $_REQUEST['payment_type'];
        $where['lesson_id'] = $_REQUEST['lesson_id'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['courseStartDate'] = $_REQUEST['courseStartDate'];
        $where['courseEndDate'] = $_REQUEST['courseEndDate'];
        $where['order_sn'] = $_REQUEST['order_sn'];
        $where['startDate'] = $_REQUEST['startDate'];
        $where['endDate'] = $_REQUEST['endDate'];
        $where['mobile'] = $_REQUEST['mobile'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['payment_state'] = $_REQUEST['payment_state'];
        $where['page'] = '';
        //print_r($where);die;
        $pageUrl = site_url('/order/index') . '?' . http_build_query($where);
        $pageIndex = (int)$_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit = self::PAGE_SIZE;
        $count = $this->m_order->getList($where, '', '',0);
        $data = $this->m_order->getList($where, $offset, $limit,1);
        //print_r($data);die;
        $bpage = new BPage(self::PAGE_SIZE, $count, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();

        $lessonType = $this->m_lesson->getLessonType();
        $status = $this->m_order->getOrderStatus();
        $paymentType = $this->m_order->getPaymentType();

        $teacher = $this->m_teacher->get(array('status'=>1));
        $site = $this->m_site->get(array('status'=>1));
        $this->load->view('order/index', compact('where','status','paymentType', 'lessonType','data', 'pagination','site','teacher'));
    }

    //列表导出
    public function exportOrder() {
        $where['site_id'] = $_REQUEST['site_id'];
        $where['mobile'] = $_REQUEST['mobile'];
        $where['lesson_type'] = $_REQUEST['lesson_type'];
        $where['payment_type'] = $_REQUEST['payment_type'];
        $where['lesson_id'] = $_REQUEST['lesson_id'];
        $where['teacher_id'] = $_REQUEST['teacher_id'];
        $where['courseStartDate'] = $_REQUEST['courseStartDate'];
        $where['courseEndDate'] = $_REQUEST['courseEndDate'];
        $where['course_date'] = $_REQUEST['course_date'];
        $where['order_sn'] = $_REQUEST['order_sn'];
        $where['startDate'] = $_REQUEST['startDate'];
        $where['endDate'] = $_REQUEST['endDate'];
        $where['payment_state'] = $_REQUEST['payment_state'];
        $list = $this->m_order->getList($where, 0, 100000,1);
        $lessonType = $this->m_lesson->getLessonType();
        $status = $this->m_order->getOrderStatus();
        $paymentType = $this->m_order->getPaymentType();
        foreach ($list as $key => $val) {
            if ($val['payment_state']>3) {
                $val['payment_state']=3;
            }
            $data['v1'] = $val['order_sn'];
            $data['v2'] = $val['nickname'];
            $data['v3'] = $val['mobile'];
            $data['v4'] = $val['teacher_name'];
            $data['v5'] = $val['lesson_name'];
            $data['v6'] = $val['site_name'];
            $data['v7'] = $lessonType[$val['lesson_type']];
            $data['v8'] = $val['total_price'];
            $data['v9'] = $val['deduction_price'];
            $data['v10'] = $val['actual_price'];
            $data['v11'] = $val['course_date'];
            $data['v12'] = $val['begin_time'];
            $data['v13'] = $val['create_time'];
            $data['v14'] = $paymentType[$val['payment_type']];
            $data['v15'] = $status[$val['payment_state']];
            $dataInfo[] = $data;
        }
        //print_r($dataInfo);die;
        $title = array(
            '订单号',
            '昵称',
            '手机号',
            '老师',
            '课程',
            '场地',
            '类型',
            '课价',
            '优惠',
            
            '实付',
            '上课日期',
            '上课时间',
            '下单时间',
            '付款方式',
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