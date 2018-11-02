<?php

require_once APPPATH.'module/base_Model.php';
class M_bonus_master extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "bonus_master";
    }

    public function getBonusType(){
        return array(
            '1' => '通用券',
            '2' => '精品小班券',
            '3' => '私教券',
            '4' => '伙伴券',
            '5' => '精练计划券',
        );
    }
    public function getBonusCategory(){
        return array(
            '1' => '注册发放',
            '2' => '邀请发放',
            '3' => '手动发放',
            '4' => '主动领取',
        );
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
        $sql = " select " . $condition . " from " .$this->table ." where status>=0 ";
       
        if($where['keyword'] != ''){
            $sql .= " and bonus_name = " .$where['keyword'];
        }
        if(!empty($where['type'])){
            $sql .= " and bonus_type = ".$where['type'];
        }
         if(!empty($where['category'])){
            $sql .= " and category = ".$where['category'];
        }
        //echo $sql;die;
        if($type == 0){
            $count = $this->db->query($sql)->row_array();
            return $count['count'];
        }
        if($type == 1){
            $sql .= " order by create_time desc  limit {$limit},{$offset}";
            $data = $this->db->query($sql)->result_array();
            foreach ($data as $key => $value) {
                $data[$key]['sent_num'] = $this->getBonusLogList(array('bonus_id'=>$value['bonus_id']),'','',0);
                $data[$key]['use_num'] = $this->getBonusLogList(array('bonus_id'=>$value['bonus_id'],'status'=>2),'','',0);
            }
            return $data;
        }

    }

    //发放列表
    public function getBonusLogList($where = array(), $limit = '', $offset = '', $type = 0)
    {
        if ($type == 0) {
            $condition = " count(*) as count ";
        }
        if ($type == 1) {
            $condition = "a.id,a.uid,a.bonus_id, a.status,a.use_time,a.begin_date,a.end_date,a.param,b.bonus_name,a.create_time,b.bonus_type,b.category,b.amount,c.mobile,c.nickname";
        }
        $sql = " select " . $condition . " from bonus_give_log a 
            join bonus_master b on a.bonus_id=b.bonus_id
            join user_master c on a.uid=c.uid
             where 1 ";
       
        if(!empty($where['param'])){
            $sql .= " and a.param like '%" . $where['param'] . "%' ";
        }
        if(!empty($where['keyword'])){
            $sql .= " and b.bonus_name like '%" . $where['keyword'] . "%' ";
        }
        if(!empty($where['type'])){
            $sql .= " and b.bonus_type = ".$where['type'];
        }
        if(!empty($where['category'])){
            $sql .= " and b.category = ".$where['category'];
        }
        if(!empty($where['status'])){
            $sql .= " and a.status = ".$where['status'];
        }
        if(!empty($where['bonus_id'])){
            $sql .= " and a.bonus_id = ".$where['bonus_id'];
        }
        if($where['nickname'] != ''){
            $sql .= " and c.nickname = '" .$where['nickname']."'";
        }
        if($where['mobile'] != ''){
            $sql .= " and c.mobile = '" .$where['mobile']."'";
        }
        if($where['uid'] != ''){
            $sql .= " and c.uid = '" .$where['uid']."'";
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