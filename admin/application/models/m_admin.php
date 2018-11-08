<?php
//后台用户中心相关model
class M_admin extends CI_Model {
    
    private $admin_table = 'admin_master';
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

    /*     * *
     * 获取用户的信息
     * 包括用户的基本信息、角色信息等（涉及到的表:admin_master/jz_oper_role
     */

    public function getInfoById($admin_id) {
        $sql = 'SELECT a.* ,b.name as rolename ,b.menu_id from admin_master as a LEFT JOIN jz_oper_role as b on a.role_id=b.id where a.id=' . $admin_id;
        $result = $this->db->query($sql)->row_array();
        return $result;
    }

   

    /**
    *@desc 检查账号是否存在
    */
    public function isExist($username,$uid='') {
        $sql = "SELECT count(id) as count FROM ".$this->admin_table." WHERE username = '{$username}' and status>=0";
        if (!empty($uid)) {
            $sql .= " and id != ".$uid;
        }
        $result = $this->db->query($sql)->row_array();
        if ($result['count'] > 0) {
            return TRUE;
        }else {
            return FALSE;
        }
    }

    /**
    *@desc 手机号是否存在
    **/
    public function isExistMoible($username,$uid='') {
        $sql = "SELECT count(id) as count FROM ".$this->admin_table." WHERE mobile = '{$username}' and status>=0";
        if (!empty($uid)) {
            $sql .= " and id != ".$uid;
        }
        $result = $this->db->query($sql)->row_array();
        if ($result['count'] > 0) {
            return TRUE;
        }else {
            return FALSE;
        }
    }

    public function updateByWhere($where = array(),$data = array()){
        
        
        return $this->db->update($this->admin_table,$data,$where);
    }

    public function getPermission(){
        $loginUid = $_SESSION['zhimei_uid'];
        if(empty($loginUid)){return array();}
        $userInfo = $this->getInfoById($loginUid);
        if ($userInfo && !empty($userInfo['menu_id'])) {
            $leftMenuIds = json_decode($userInfo['menu_id'],true);
            $this->db->where(array('is_show'=>1,'status'=>1, 'type' => 1));
            $this->db->where_in('id',$leftMenuIds);
            $leftMenu = $this->db->get('jz_oper_menu')->result_array();
            $tree = $this->getTree($leftMenu, 0);
            return $tree;
        }
    }

   public function getTree($data, $pId) {
        $tree = '';
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pId) {         //父亲找到儿子
                $v['children'] = $this->getTree($data, $v['id']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }
   



   public function passwordCheck($password = '',$level=1) {
        $this->load->model('m_admin_set_config_master');
        $config = $this->m_admin_set_config_master->getRow(array('config_id' => 4));
        $level = $config['config_status'];
        if ($level==1) {
            if (preg_match('/^(?=^.*?\d)(?=^.*?[a-z])^[0-9a-z]{6,16}$/', $password)){
                return 1;
            }else{
                return '格式不正确，请输入数字+字母的6-16位字符';
            }
        }elseif ($level==2) {
            if (preg_match('/^(?=^.*?\d)(?=^.*?[a-z])(?=^.*?[A-Z])^[0-9a-zA-Z]{6,16}$/', $password)){
                return 1;
            }else{
                return '格式不正确，请输入数字+大小写字母的6-16位字符';
            }
        }elseif ($level==3) {
            if (preg_match('/^(?=^.*?\d)(?=^.*?[a-z])(?=^.*?[A-Z])(?=^.*?[\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|])^[0-9a-zA-Z\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|]{6,16}$/', $password)){
                 return 1;
            }else{
                return '格式不正确，请输入数字+大小写字母+字符的6-16位字符';
            }
        }
       
    }

    public function checkPassOuttime($userInfo,$num=0){
        $createDate = date("Y-m-d",strtotime($userInfo['create_time']));   
        $updatepassDate = date("Y-m-d",strtotime($userInfo['updatepass_time'])); 
        
        $countDays_create=floor((time()-strtotime($userInfo['create_time']))/86400);
        $cookie_key = $userInfo['id'].'checkPassOuttime';
        if (isset($_COOKIE[$cookie_key]) && $_COOKIE[$cookie_key]==date("Ymd")) {
            return array('code'=>0,'data'=>0);
        }
        
        
        if(empty($userInfo['updatepass_time'])){
            if ($countDays_create>=60 && $countDays_create<=90) {
                if($num==1){
                    setcookie($cookie_key,date('Ymd'),time()+86400,"/");
                }
                
                return array('code'=>1,'data'=>90-$countDays_create);
            }elseif ($countDays_create>90) {
                return array('code'=>2,'data'=>90-$countDays_create);
            }
            // if($createDate <= date("Y-m-d",strtotime("-60 days")) && $createDate >= date("Y-m-d",strtotime("-90 days"))){
            //     return 1;//超出 60-90内
            // }elseif($createDate < date("Y-m-d",strtotime("-90 days"))){
            //     return 2;//超出 90天
            // }

        }else{
            $countDays_update=floor((time()-strtotime($userInfo['updatepass_time']))/86400);

            if ($countDays_update>=60 && $countDays_update<=90) {
                if($num==1){
                    setcookie($cookie_key,date('Ymd'),time()+86400,"/");
                }
                return array('code'=>1,'data'=>90-$countDays_update);
            }elseif ($countDays_update>90) {
                return array('code'=>2,'data'=>90-$countDays_update);
            }

            // if($updatepassDate <= date("Y-m-d",strtotime("-60 days")) && $updatepassDate >= date("Y-m-d",strtotime("-90 days"))){
            //    return 1;//超出 60-90内
            // }elseif ($updatepassDate < date("Y-m-d",strtotime("-90 days"))) {
            //       return 2;//超出 90天
            // }
        }

        return array('code'=>0,'data'=>0);
    }









 }
