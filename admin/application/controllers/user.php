<?php

/*
 * 用户模块:包括用户登陆功能
 * 
 */

class User extends MY_Controller {
	const PAGE_SIZE = 10;
	private $roleList;
	public function __construct(){
        parent::__construct() ;
        $this->load->model('m_admin');
       
        $this->load->library(array('session','Image'));
    	require_once APPPATH.'/libraries/String.php';
    }

    public function login(){
         $this->load->view('user/login');
    	// $this->load->view('user/mobilelogin');
        
    }
    public function findpass(){
         $this->load->view('user/findpass');
        
    }



 //生成验证码   
    public function captcha(){   
    	ob_clean();
	    $fonttype=BASEPATH.'/fonts/1.ttf';       

	    $img_output=$this->image->buildImageVerify(4,5,'png',85,35,'verify',$fonttype);
	    
	    $this->session->set_userdata('vcode', $img_output['vcode']);
	    
	    $this->image->output($img_output['im'],$img_output['type']);
    }
    
	public function actionlogin() {

		$username = $this->input->post('username');
 		$password = $this->input->post('password');
        $captcha_code = $this->input->post('captcha_code');
        $mobile = $this->input->post('mobile');
 		$remember = $this->input->post('remember');
      
        if (empty($username) || empty($password)) {
        	 $this->returnJson(201,'参数错误');
        }
        $vcode       = strtolower($this->session->userdata('vcode'));
       
         if($vcode!=strtolower($captcha_code)){
             // $this->returnJson(203,'图文验证码错误');
         }

        $sql = "SELECT a.* from admin_master a  where   a.state=1 and (a.mobile=? or a.username=?)";
        $user = $this->db->query($sql,array($username,$username))->row_array();
       
        if (!isset($user['username'])){
            $this->returnJson(204,'账户不存在');
        }
        elseif ($user['password'] !== md5($password)){
             $this->returnJson(205,'密码错误');
        }
            

        $apikey = md5($user['id'] . time());
        $_SESSION['yoyoga_uid'] = $user['id'];
        $_SESSION['yoyoga_username'] = $user['username'];
        $_SESSION['yoyoga_apikey'] = $apikey;
       
        if ($remember==1) {
            setcookie('yoyoga_remember', $remember, time()+3600*24*7,'/');
            setcookie('yoyoga_remember_username', $username, time()+3600*24*7,'/');  
            setcookie('yoyoga_remember_password', $password, time()+3600*24*7,'/');  
        }else{
            setcookie('yoyoga_remember', $remember, time()-3600,'/');
            setcookie('yoyoga_remember_username', $username, time()-3600,'/');  
            setcookie('yoyoga_remember_password', $password, time()-3600,'/');  
        }
		$data = array();
        $data['info'] = $user;

        
		$this->returnJson(200,'信息返回',$data);
        
	}


	//注销
	public function logout() {
         // $this->m_log->insertLog(5,1,'');
			unset($_SESSION['yoyoga_uid']);
			redirect('/user/login');

	}



 public function index() {

      
        $request = array();
        $request['username'] = $_REQUEST['username'];
        $request['mobile'] = $_REQUEST['mobile'];
        $request['realname'] = $_REQUEST['realname'];
        $request['role_id'] = $_REQUEST['role_id'];
        $request['state'] = $_REQUEST['state'];
        $request['page'] = '';
        $pageUrl = site_url('/user/index') . '?' . http_build_query($request);
        $pageIndex = (int) $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $pagesize = (int) $_REQUEST['pagesize'];
        $params = array();
      
        $condition = "state>'-1' ";
        if ($request['state'] == '0') {
            $condition .= " and state = '0' ";
        }
        if ($request['state'] == '1') {
            $condition .= " and state = '1' ";
        }
        if ($request['role_id']) {
            $condition .= " and role_id = '" . $request['role_id'] . "' ";
        }
        if ($request['realname']) {
            $condition .= " and realname = '" . $request['realname'] . "' ";
        }
        if ($request['username']) {
            $condition .= " and username = '" . $request['username'] . "' ";
        }
        if ($request['mobile']) {

            $condition .= " and mobile LIKE '" . $request['mobile'] . "%' ";
        }
        
       
        $offset = ($pageIndex - 1) * self::PAGE_SIZE;
        $limit  = self::PAGE_SIZE;
        
        $sql = "SELECT * FROM admin_master where ".$condition." order by id desc limit $offset,$limit";
        $list = $this->db->query($sql)->result_array();
        
        $tsql = "SELECT count(*) as count FROM admin_master where ".$condition;
        $row = $this->db->query($tsql)->row_array();
        $total =  $row['count'];
        
        
        $bpage = new BPage(self::PAGE_SIZE, $total, $pageIndex, 10, $pageUrl);
        $pagination = $bpage->showPageHtml();

       	foreach ($list as $key => $value) {
       		$role = $this->m_role->getInfoById($value['role_id']);
       		$list[$key]['rolename'] = $role['name'];
       	}
		$roleList = $this->roleList;
        $this->load->view('user/index', compact('list', 'pagination', 'request','roleList'));
    }

    public function add() {
        $roleList = $this->roleList;
       $error = '';
       $json = $this->input->post('json');
       if($json==1){

           if (isset($_POST['JzOperAdmin']['password']) and strlen($_POST['JzOperAdmin']['username']) and strlen($_POST['JzOperAdmin']['password']) and strlen($_POST['JzOperAdmin']['realname']) and strlen($_POST['JzOperAdmin']['role_id'])) {
                $password = $_POST['JzOperAdmin']['password'];
                $_POST['JzOperAdmin']['password'] =  md5($password);

                $checkPass = $this->m_admin->passwordCheck($password);

                if($checkPass != 1){
                     sendjson(array(
                        'msg' =>  $checkPass,
                        'status' => -2));exit();
                   
                   
                }


                $mobile = $_POST['JzOperAdmin']['mobile'];
           
                $isExist = $this->m_admin->isExistMoible($mobile,$id);
                if($isExist){
                     // $this->m_log->insertLog(2,0,'手机号码已经存在');
                     sendjson(array(
                        'msg' => '手机号码已经存在',
                        'status' => -3));exit();
                   
                }

                $username = $_POST['JzOperAdmin']['username'];
                $isExist = $this->m_admin->isExist($username);
                if($isExist){
                     // $this->m_log->insertLog(2,0,'账号已经存在');
                    sendjson(array(
                        'msg' => '账号已经存在',
                        'status' => -4));exit();
                    
                }

                $_POST['JzOperAdmin']['create_time'] = date("Y-m-d H:i:s");
                $_POST['JzOperAdmin']['update_time'] = date("Y-m-d H:i:s");
                $_POST['JzOperAdmin']['updatepass_time'] = date("Y-m-d H:i:s");
                 $rs = $this->db->insert('admin_master',$_POST['JzOperAdmin']);
            
                if ($rs) {
                     // $this->m_log->insertLog(2,1,'');
                   sendjson(array(
                        'msg' => 'success',
                        'status' => 1));exit();
                } 
               
            }else{
                 sendjson(array(
                'msg' => '参数错误',
                'status' => -1));exit();
            }
        
       }
        
       

        $this->load->view("user/add", compact('roleList','error'));
    }

    public function edit() {
        $error = '';
        $id = $this->input->get("id");
        $info = $this->m_admin->getInfoById($id);

        if (isset($_POST['JzOperAdmin'])) {


            $mobile = $_POST['JzOperAdmin']['mobile'];
            $isExist = $this->m_admin->isExistMoible($mobile,$id);
            if($isExist){
                $error = '手机号码已经存在';
            }else{




                $username = $_POST['JzOperAdmin']['username'];
                $isExist = $this->m_admin->isExist($username,$id);
                if($isExist){
                    $error = '账号已经存在';
                }else{
                    $_POST['JzOperAdmin']['update_time'] = date("Y-m-d H:i:s");
                   $rs = $this->m_admin->updateByWhere(array('id' =>$id),$_POST['JzOperAdmin']);
                    
                    if ($rs) {
                        redirect('/user/index');
                    } 
                }
            }
        }
        $roleList = $this->roleList;
       
        $this->load->view("user/edit", compact('info', 'roleList','error'));
    }

    public function editpass() {
         header("Content-type: text/html; charset=utf-8"); 
        $id = $this->input->get("id");
        $info = $this->m_admin->getInfoById($id);

        if (isset($_POST['password']) && !empty($_POST['password'])) {
        	$password = $_POST['password'];
        	$confirm_pass = $_POST['confirm_pass'];
        	if ($password == $confirm_pass) {
                $checkPass = $this->m_admin->passwordCheck($password);

                if($checkPass != 1){
                    // $this->m_log->insertLog(3,0,$checkPass);
                    echo "<script>alert('".$checkPass."');location.href='/user/editpass?id={$id}';</script>";exit;
                }
        		$password = md5($password);
                if($password == $info['password']){
                     // $this->m_log->insertLog(3,0,'修改密码不能与原密码一致');
                    echo "<script>alert('修改密码不能与原密码一致');location.href='/user/editpass?id={$id}';</script>";exit;
                }
        		$rs = $this->m_admin->updateByWhere(array('id' =>$id),array('password'=>$password,'updatepass_time'=>date("Y-m-d H:i:s")));
	            
	            if ($rs) {
                     // $this->m_log->insertLog(3,1,'');
	                redirect('/user/logout');
	            } 
        	}
        	
           
        }
        $roleList = $this->roleList;
       
        $this->load->view("user/editpass", compact('info', 'roleList'));
    }
    public function updateState() {
        
        $id = $this->input->post("id");
        $state= $this->input->post("state");
        $info = $this->m_admin->getInfoById($id);
        $res = array();
        if (empty($info)) {
            $res['success'] = '0';
            $res['msg'] = '参数错误';
            exit(json_encode($res));
        }

        
        $rs = $this->m_admin->updateByWhere(array('id' =>$id) , array('state'=>$state));

        if ($rs) {
            $res['success'] = 1;
            $res['msg'] = '成功';
        } else {
            $res['success'] = '2';
            $res['msg'] = '失败';
        }
        exit(json_encode($res));
    }


   public function forceEditpass() {
        header("Content-type: text/html; charset=utf-8"); 

       $username = $_POST['username'];
       $password = $_POST['password'];
       $confirm_pass = $_POST['confirm_pass'];
       $sql = "SELECT * FROM admin_master WHERE mobile = '{$username}' and state>=0";
       
        $result = $this->db->query($sql)->row_array();
        if(!$result){
            $res['status'] = '0';
            $res['msg'] = '账号不存在';
            exit(json_encode($res));
        }
        
        if ($password == $oldpass) {
            $res['status'] = '0';
            $res['msg'] = '修改密码不能与原密码一致';
            exit(json_encode($res));
        }
        if ($password != $confirm_pass) {
            $res['status'] = '0';
            $res['msg'] = '确认密码不一致不正确';
            exit(json_encode($res));
        }
/*
        $checkPass = $this->m_admin->passwordCheck($password);
        if($checkPass != 1){
            $res['status'] = '0';
            $res['msg'] = $checkPass;
            exit(json_encode($res));
        }
        */
        $password = md5($password);
        $rs = $this->m_admin->updateByWhere(array('id' =>$result['id']),array('password'=>$password,'updatepass_time'=>date("Y-m-d H:i:s")));
        
    
        if ($rs) {
            $res['status'] = 1;
            $res['msg'] = '成功';
        } else {
            $res['status'] = '2';
            $res['msg'] = '失败';
        }
        exit(json_encode($res));
    }

   public function  SmsVerificationCode()
    {
        $mobile = $this->input->post('mobile');
        if (isset($mobile) && $mobile == '') {
            sendjson(array(
                'msg' => "手机号码不能为空",
                'status' => -2));
            exit();
        }
        if(! mobileCheck($mobile)){
            sendjson( array(
                'msg'=>'手机号格式不正确',
                'status'=>-3));
            exit();
        }

        $isExist = $this->m_admin->isExistMoible($mobile);
        if(!$isExist){
            sendjson( array(
            'msg'=>'手机号码尚未注册，请先联系管理员',
            'status'=>-4));
            exit();
           
        }

        $data['mobile'] = $mobile;
        $data['model'] = 1;
        $data['code'] = getAuthCode(6,1,"0123456789");
        if(!SMS_DEBUG) {
            $result = curlPost(SERVICE_URL."sms/sendsms/sendSmsModel",$data);
        }else{
            debugLog('尊敬的用户：您本次的短信验证码是'.$data['code']);
        }
        if (json_decode($result,true)['status'] == 1) {
            sendjson(array(
                'msg'=>'短信发送成功,请输入短信验证码',
                'status'=>1));
        }else{
            sendjson(array(
                'msg'=>'短信发送失败',
                'status'=> 0));
        }
    }


    public function checkCode()
    {
        sendjson(array(
                'msg'=>'验证码正确',
                'status'=>1));
        exit;
        $result = $_POST;
        $mobile = trim($result['mobile']);//手机号
        $mobileCode = trim($result['mobileCode']);//短信验证码
        if (isset($mobileCode) && $mobileCode == '') {
            sendjson(array(
                'msg' => '短信验证码不能为空',
                'status' => -6));exit();
        }
        $data['mobile'] = $mobile;
        $data['model'] = 1;
        $data['code'] = $mobileCode;
       
        // $result = curlPost(SERVICE_URL."sms/sendsms/checkCode",$data);
        if (json_decode($result,true)['status'] == 1) {
            sendjson(array(
                'msg'=>'验证码正确',
                'status'=>1));
        }else{
            sendjson(array(
                'msg'=>'验证码错误',
                'status'=> 0));
        }
       
    }


}

