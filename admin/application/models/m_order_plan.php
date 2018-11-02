<?php
require_once APPPATH.'module/base_Model.php';
class M_order_plan extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'order_plan_master';
       
    }    

    public function getOrderStatus(){
        return array(
            '-1' => '已关闭',
            '1' => '待支付',
            '2' => '已支付',
            '3' => '未评价',
            '4' => '已评价',
        );
    }
    public function getPaymentType(){
        return array(
            '1' => '微信',
            '2' => '精练计划',

        );
    }
    //列表
  
    public function getList($where = array(), $limit = '', $offset = '', $type = 0)
    {
        if ($type == 0) {
            $condition = " count(*) as count ";
        }
        if ($type == 1) {
            $condition = " a.*,b.nickname,b.mobile ";
        }
        $sql = " select " . $condition . " from order_plan_master  a
                left join user_master b on a.uid=b.uid
             where a.status=1 ";
       
        
        if(!empty($where['site_id'])){
            $sql .= " and a.site_id = ".$where['site_id'];
        }
        
        if(!empty($where['order_sn'])){
            $sql .= " and a.order_sn = '" .$where['order_sn']."'";
        }
        if(!empty($where['course_date'])){
            $sql .= " and a.course_date = '" .$where['course_date']."'";
        }
        if(!empty($where['lesson_type'])){
            $sql .= " and a.lesson_type = ".$where['lesson_type'];
        }
         if(!empty($where['payment_state'])){
            $sql .= " and a.payment_state = ".$where['payment_state'];
        }
        
        if($where['teacher_id'] != ''){
            $sql .= " and a.teacher_id = '" .$where['teacher_id']."'";
        }
        if($where['lesson_id'] != ''){
            $sql .= " and a.lesson_id = '" .$where['lesson_id']."'";
        }
        if ($where['startDate'] != '') {
            $sql .= " and a.create_time >= '" . $where['startDate'] . " 00:00:00 ' ";
        }
        if ($where['endDate'] != '') {
            $sql .= " and a.create_time < '" . $where['endDate'] . " 23；59:59 '";
        }
        if(!empty($where['payment_type'])){
            $sql .= " and a.payment_type = ".$where['payment_type'];
        }
        if(!empty($where['plan_type'])){
            $sql .= " and a.plan_type = ".$where['plan_type'];
        }
        
        
        // echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by a.create_time desc  limit {$limit},{$offset}";
            $data = $this->db->query($sql)->result_array();
           
            return $data;
        }

    }
    









    
}