<?php

/**
 * @Author: wupengzheng
 * @Date:   2016/3/21 19:47
 * @Last Modified by:   wupengzheng
 * @Last Modified time: 2016/3/21 19:47
 */
class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("m_finace");
    }
    public function callback(){
        header('Content-type: text/html; charset=utf-8');
        $resp = $_POST['resp'];//返回xml
        $sign = $_POST['sign'];
        $result = $this->dataResponse($resp,$sign,1);
        if($result){

        }
    }
    public function notify(){
        header('Content-type: text/html; charset=utf-8');
        $resp = $_POST['notify'];
        $sign = $_POST['sign'];
        $result = $this->dataResponse($resp,$sign,2);
        if($result){
            return "SUCCESS";
        }
    }
    public function dataResponse($resp,$sign,$type){
        //数据处理
        $xml = simplexml_load_string($resp);
        $requestNo = $xml->requestNo;
        $service = $xml->service;
        $code = $xml->code;
        $description = $xml->description;
        $data = $this->m_finace->getEnterInfo(array("request_no"=>$requestNo));
        if($code == 1){
            if($type == 1){
                $this->m_finace->updateLog("eb_register_log",array('request_no'=>$requestNo,'uid'=>$data['uid']),array(
                    'callback_xml'=>$xml,
                    'callback_sign'=>$sign,
                    'update_time'=>date('Y-m-d H:i:s'),
                    'register_status'=>1
                ));
                $this->updateData();
                return true;
            }else{
                $this->m_fincae->insertLog("eb_notify_log",array(
                    'uid'=>$data['uid'],
                    'request_no' =>$requestNo,
                    'notify_type'=> 8,
                    'order_id'=>$data['id'],
                    'notify_status'=>1,
                    'notify_xml'=>$xml,
                    'notify_sign'=>$sign,
                    'create_time'=>date('Y-m-d H:i:s'),
                    'description'=>"企业注册"
                ));
                $this->updateData();
                return true;
            }
        }else{
            $this->m_finace->updateLog("eb_register_log",array('request_no'=>$requestNo,'uid'=>$data['uid']),array(
                'callback_xml'=>$xml,
                'callback_sign'=>$sign,
                'update_time'=>date('Y-m-d H:i:s'),
                'register_status'=>-1
            ));
            $this->m_finace->update(array('uid'=>$data['uid']),array('flag_register_ebpay'=>0,'eb_platform_no'=>$data['platform_no'],'update_time'=>date('Y-m-d H:i:s')));
            $this->m_finace->updateData('eb_enterprise_register_log',array('uid'=>$data['uid'],'request_no'=>$requestNo),array('status'=>3,'update_time'=>date('Y-m-d H:i:s')));
            return false;
        }
    }
    public function updateData(){
        $this->m_finace->update(array('uid'=>$data['uid']),array('flag_register_ebpay'=>1,'eb_platform_no'=>$data['platform_no'],'update_time'=>date('Y-m-d H:i:s')));
        $this->m_finace->updateData('eb_enterprise_register_log',array('uid'=>$data['uid'],'request_no'=>$requestNo),array('status'=>2,'update_time'=>date('Y-m-d H:i:s')));
        $this->m_finace->insertData("lay_account_user",array('uid'=>$data['uid'],'create_time'=>date('Y-m-d H:i:s')));
        $this->m_finace->insertData("eb_account_user",array('uid'=>$data['uid'],'create_time'=>date('Y-m-d H:i:s')));
    }
}