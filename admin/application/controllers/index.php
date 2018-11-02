<?php

class Index extends MY_controller  {

	public function __construct(){

        parent::__construct() ;
         $this->load->model('m_admin');
        
    }

    public function index(){
    	$userInfo = $this->loginUser;
    	$this->load->view("index/index",array('userInfo'=>$userInfo));
    }


}

?>