<?php

/**
* 用户model
*/

require_once APPPATH.'module/base_Model.php';
class M_user_master extends Base_Model
{
		
	function __construct()		
	{
		parent::__construct();
		$this->table = 'user_master';
	}
	public function insertId($data){
		$this->insert($data);
		return $this->db->insert_id();
	}
    public function getUserStatus(){
        return array('1'=>'启用','2'=>'停用');
    }
//获取约课次数
    public function getOrderCount($uid){
        $sql = "select count(*) as count from order_master where uid={$uid} and payment_state>1";
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }

    //获取最后一次约课
    public function getLastCourse($uid){
        $sql = "select *  from order_master where uid={$uid} and payment_state>1 order by begin_time desc limit 1";
        $row = $this->db->query($sql)->row_array();

        return $row;
    }


//第一次上课时间
    public function getFirstCourseTime($uid){
        $sql = "select *  from order_master where uid={$uid} and payment_state>1 order by begin_time asc limit 1";
        $row = $this->db->query($sql)->row_array();
        if ($row) {
            return $row;
        }else{
            return '';
        }
        
    }

    public function getLostDay($uid){
        $last = $this->getLastCourse($uid);
        if($last){
            $nowTime = date("Y-m-d");
            $loseDay = $this->diffBetweenTwoDays($nowTime,$last['course_date']);
        }else{
            $loseDay = -1;
        }
        return $loseDay;
        
    }
    //列表
    public function getList($where = array(), $limit = '', $offset = '', $type = 0)
    {
        if ($type == 0) {
            $condition = " count(*) as count ";
        }
        if ($type == 1) {
            $condition = " * ";
        }
        $sql = " select " . $condition . " from " .$this->table ." where status=1 ";
       
        if(!empty($where['status'])){
            $sql .= " and status = ".$where['status'];
        }
        
       
        if($where['mobile'] != ''){
            $sql .= " and mobile = '" .$where['mobile']."'";
        }
        if(!empty($where['keyword'])){
            $sql .= " and nickname like '%" . $where['keyword'] . "%' ";
        }
         if ($where['startDate'] != '') {
            $sql .= " and create_time >= '" . $where['startDate'] . " 00:00:00 ' ";
        }
        if ($where['endDate'] != '') {
            $sql .= " and create_time < '" . $where['endDate'] . " 23；59:59 '";
        }
        if ($where['share_user_id']!='') {
            if ($where['share_user_id']==2) {
                 $sql .= " and share_user_id = 0";
            }elseif ($where['share_user_id']==1) {
                 $sql .= " and share_user_id >0";
            }
        }
        //echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by create_time desc  limit {$limit},{$offset}";
            $data = $this->db->query($sql)->result_array();
            $nowTime = date("Y-m-d H:i:s");
            foreach ($data as $key => $value) {
                $loseDay = $this->getLostDay($value['uid']);
                
                $data[$key]['loseDay'] = $loseDay;
                $data[$key]['orderCount'] = $this->getOrderCount($value['uid']);
            }
            return $data;
        }

    }


/**
 * 求两个日期之间相差的天数
 * @param string $day1 "2013-07-27";
 * @param string $day2 "2013-08-27";
 * @return number
 */
    function diffBetweenTwoDays ($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);
        if ($second2>$second1) {
            return 0;
        }
        return floor(($second1 - $second2) / 86400);
    }



}