<?php
/**
*  后台基类
*/
include(APPPATH.'/libraries/BPage.php');
class MY_controller extends CI_Controller
{
	
	public  $loginUid;
	public  $loginUser;
	function __construct()
	{
		parent::__construct();
		// $this->load->library(array('session','form_validation','input','encrypt'));
        //$this->load->helper(array('form', 'url','user','cookie','common'));

		$this->load->database();
		
		if (isset($_SERVER['REQUEST_URI']) &&
        	(
        	 strstr($_SERVER['REQUEST_URI'], '/user/login') == true
        	 ||strstr($_SERVER['REQUEST_URI'], '/user/actionlogin') == true
        	 ||strstr($_SERVER['REQUEST_URI'], '/user/SmsVerificationCode') == true
        	 ||strstr($_SERVER['REQUEST_URI'], '/user/checkCode') == true
        	 ||strstr($_SERVER['REQUEST_URI'], '/user/findpass') == true
        	 ||strstr($_SERVER['REQUEST_URI'], '/user/forceEditpass') == true
        	 ||strstr($_SERVER['REQUEST_URI'], '/user/captcha') == true
        	)
        ){
		}else{

			if (!isset($_SESSION['yoyoga_uid']) || empty($_SESSION['yoyoga_uid'])) {
	            redirect('/user/login','location');exit;
	        } 
	        $this->loginUid = $_SESSION['yoyoga_uid'];
	        $sql = 'SELECT a.*  from admin_master as a  where a.id=' . $this->loginUid;
	        
	        $userInfo = $this->db->query($sql)->row_array();
	        
	        if (empty($userInfo)) {
	        	 redirect('/user/login','location');exit;
	        }
			$this->loginUser = $userInfo; 

   		}
	}

	public function kickOut()
	{
		session_destroy();
		header('Content-type: text/html; charset=utf-8');
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			$data['data'] = array();
        	$data['status'] = 2;
        	$data['backurl'] = '/user/login';
        	$data['msg'] = '您的帐号在其它地方登录，您已被迫下线，如果不是您本人操作，请及时修改密码！';
        	die(json_encode($data));

		}else{
			echo '<script type="text/javascript">alert("您的帐号在其它地方登录，您已被迫下线，如果不是您本人操作，请及时修改密码！");location.href="/user/login"; </script>';
		}
		die();
	}

	public function returnJson($code,$msg,$data=array()){
    	$returnData = array('status' => $code,'msg' => $msg);
		$returnData['data'] = $data;
		$return = json_encode($returnData);
		echo $return;
		exit;

	}
}
?>