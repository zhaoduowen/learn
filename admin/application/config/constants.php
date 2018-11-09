<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */


define('BASE_URL',              config_item('base_url')); //base_url

define("DEBUG",                         TRUE);  //调试模式 -- 控制调试日志输出
//短信
define("SMS_DEBUG",                     TRUE);  //短信调试模式，不发送，验证码都为1;FALSE正式，开发TRUE

define('W_STATIC_URL',  	BASE_URL . 'public/'); 
define('G_UPLOAD', dirname(dirname(__FILE__)).'/../upload');             //图片保存路径   
define('G_IMAGE_DOMAIN', 'http://admin.yowang.cn/upload');             //上传图片域名   
define('LOG_ADDRESS', 		    'application/logs');	//LOG日志的保存地址
