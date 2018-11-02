<?php
/**
 * 帮助类，常用方法
 */

if (!function_exists('dealPic')) {
        function dealPic($imageUrl,$type='') {
        $imageArr = array('s' => '', 'b' => '', 'l' => '');
        if (empty($imageUrl)) {
            return '';
        }
        $dirname = dirname($imageUrl);
        $imageName = strrchr($imageUrl, '/');
        $s_imageurl = $dirname . str_replace('/', '/s_', $imageName);
        $b_imageurl = $dirname . str_replace('/', '/b_', $imageName);
        $l_imageurl = $dirname . str_replace('/', '/l_', $imageName);
        $imageArr['s'] = $s_imageurl;
        $imageArr['b'] = $b_imageurl;
        $imageArr['l'] = $l_imageurl;
        if($type){
            return $imageArr[$type];
        }else{
            return $imageArr;
        }
    } 
}

if (!function_exists('PuserNo')) {
    function PuserNo($uid) {
        return '1'.substr('00000000'.$uid, -7);
    }   
}

/**
 * 数据库唯一
 */
if (!function_exists('dbID')) {
    function dbID() {
        return substr(date('ymdHis'), 0, 8) . mt_rand(1000, 9999);
    }   
}



/**
 * 创建随机不重复数字
 * @return string 
 */
if (!function_exists('createUnique')) {
    function createUnique() {
        return substr(date('ymdHis'), 0, 8) . mt_rand(100000, 999999);
    }
}


/**
 * 正则验证手机号
 * @param  string $mobile 手机号
 * @return BOOL
 */
if (!function_exists('mobileCheck')) {
    function mobileCheck($mobile = '') {
        if (preg_match('/^(13|14|15|17|18)[0-9]{9}$/', $mobile)){
            return TRUE;
        }
        return FALSE;
    }
}

/**
 * 正则验证密码
 * @param  string $password 密码
 * @return BOOL
 */
if (!function_exists('passwordCheck')) {
    function passwordCheck($password = '') {
        ///^[0-9a-zA-Z]{6,*}$/
        if (preg_match('/^(?=^.*?\d)(?=^.*?[a-zA-Z])^[0-9a-zA-Z]{6,16}$/', $password)){
            return TRUE;
        }
        return FALSE;
    }
}
//用户名验证
if (!function_exists('usernameCheck')) {
    function usernameCheck($name = '') {
         if ( preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $name)){  
            return TRUE;
        }
        return FALSE;
    }
}
//身份证验证
if (!function_exists('cardCheck')) {
    function cardCheck($card = '') {
        if (preg_match("/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/",$card)) {
            return TRUE;
        }
        return FALSE;
    }
}
if(!function_exists('emailCheck')){
    function emailCheck($email = '') {
        if (preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)) {
            return TRUE;
        }
        return FALSE;
    }
}


/**
 * 解析参数
 */
if (!function_exists('parseParams')) {
    function getYiiParams()
    {
        header('Content-type: application/json');
        // $headerParams = array_map(function($a){return $a[0];}, Yii::$app->request->getHeaders()->toArray());
        // $queryParams = array_merge(Yii::$app->request->get(), Yii::$app->request->post(), Yii::$app->request->getBodyParams(), $headerParams);
         $queryParams = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
        return $queryParams;
    }
}

/**
 * curl get 方式获取数据
 * 
 * @param string $url
 */
function curlGet($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (($tmp = curl_exec($ch)) === false) {
        return false;
    }
    curl_close($ch);
    return $tmp;
}


function curlPost($url, $params) {
    $ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;
    $ch = curl_init();
    $paramsStr = '';
    if (!empty($params)) {
        foreach ($params as $k => $v) {
            if (!empty($paramsStr)) {
                $paramsStr .= "&{$k}={$v}";
            } else {
                $paramsStr = "{$k}={$v}";
            }
        }
    }
 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER,FALSE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_POST,TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type" => "application/x-www-form-urlencoded"));
    if ($ssl){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
    }
    if (($returnData = curl_exec($ch)) === false) {
        return false;
    }
    curl_close($ch);
    return $returnData;
}

function curlJson($url, $json) {
    $ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;
    $ch = curl_init();    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER,FALSE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_POST,TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json ;charset=utf-8'));
    if ($ssl){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
    }
    if (($returnData = curl_exec($ch)) === false) {
        return false;
    }
    curl_close($ch);
    return $returnData;
}

/**
 * 生成json的函数
 * @param  value  $data 值
 * @return string       json格式化字符串
 */
if (!function_exists('sendjson')) {
    function sendjson($data) {
        echo json_encode($data);
        exit();
    }
}

if (!function_exists('returnJson')) {
    function returnJson($code,$msg,$data=''){
        $returnData = array('status' => $code,'msg' => $msg,'data'=>$data);
        $return = json_encode($returnData);
        echo $return;
        exit;

    }
}

/**
 * 获取设备信息 0 pc 以及其他  1. iOS 2.Android
 */
if (! function_exists('getDeviceType')) {
    function getDeviceType() {
        if(stripos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||stripos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            return 1;
        }else if(stripos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            return 2;
        }else{
            return 0;
        }
    }
}

/**
 * 获取客户端ip
 *
 * @return string 客户端ip字符串,xxx.xxx.xxx.xxx格式
 */
if (! function_exists('getClientIp')) {
function getClientIp() {
    $unknown = 'unknown';
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    //处理多层代理的情况,或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
    if (false !== strpos($ip, ',')) {
        $ip = reset(explode(',', $ip));
    }
    return $ip;
}
}
/**
 * 产生随机字串，可用来自动生成密码
 * 默认长度6位 字母和数字混合 支持中文
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 * @return string
 */
function getAuthCode($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {//位数过长重复字符串一定次数
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    if($type!=4) {
        $chars   =   str_shuffle($chars);
        $str     =   substr($chars,0,$len);
    }else{
        // 中文随机字
        for($i=0;$i<$len;$i++){
            $str.= self::msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1,'utf-8',false);
        }
    }
    return $str;
}

// 密码加密
function encrypt($input) {
    $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
    $input = pkcs5_pad($input, $size);
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, ERP_KEY, $iv);
    $data = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $data = bin2hex($data);
    return $data;
}

function pkcs5_pad ($text, $blocksize) {
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}
/**
 * 截取字符函数
 * 
 * @param string $str   字符串
 * @param int $start 开始截取位置
 * @param int $length 截取长度
 * @param int $flag 后尾标志
 * @param string $charset 字符类型
 * @return string 截取完的字符
 */
function subString($str, $start = 0, $length = 80, $strtag = 1, $flag = 1, $charset = 'utf-8') {
    if (empty($str))
        return $str;
    $strlen = mb_strlen($str, $charset);
    if ($strtag) {
        $str = (mb_substr(trim(strip_tags($str)), $start, $length, $charset));
    } else {
        $str = mb_substr($str, $start, $length, $charset);
    }
    if ($flag) {
        
        if ($strlen > $length) 
        {
           if($flag ==1) $str = $str . '...';
           if($flag ==2) $str = $str . '**';
        }
    }
    return $str;
}

/*
 * 保留小数位
 * num 数字
 */
function numberFormat( $number , $dist = 2  )
    {
        return number_format( keepTwoDecimalPlaces($number),2);
        //return number_format( floor( $number * pow( 10 , $dist ) ) / pow( 10 , $dist ) , $dist);
    }
/*
 * 保留小数位不加逗号
 * num 数字
 */
function keepTwoDecimalPlaces($num,$digit = 2){
    $digitParm = '%0.'.($digit + 2).'f'; 
    return substr(sprintf($digitParm,$num),0,-2); 
}

 /**
 * 格式化手机号-前后各留两位，中间****展示
 * @param  string $mobile 手机号
 * @return string         格式后的手机号
 */ 
if (!function_exists('mobileFormat')){
    function mobileFormat($mobile) {
        if (strlen($mobile) != 11) {
            return '手机号码格式不正确';
        }
        $newMobile = substr($mobile, 0,3).'****'.substr($mobile, 7, 4);
        return $newMobile;
    }   
}


/**
 * 身份证号码格式化 前后各4 中间*
 * @param  string $certNo 身份证号码
 * @return string         
 */
if (!function_exists('certNoFormat')) {
    function certNoFormat($certNo) {
        $length = strlen($certNo);
        $newNo = substr($certNo, 0, 4).'************'.substr($certNo, $length - 4, 4);
        return $newNo;
    }
}

/**
 * 银行卡格式化 前6位 后4位 中间*
 * @param  string $bankCardNo 银行卡号码
 * @return string         
 */
if (!function_exists('bankFormat')) {
    function bankFormat($bankCardNo) {
        $length = strlen($bankCardNo);
        if ($length < 10) {
            return $bankCardNo;
        }else {
            $prefix = substr($bankCardNo, 0, 6);
            $suffix =  substr($bankCardNo, $length - 4, 4);
            $middle = '';
            for($i = 0; $i < $length - 10; $i ++) {
                $middle.= '*';
            }
            return $prefix.$middle.$suffix;
        }
        
    }
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 * @author zhangjian
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}


if (!function_exists('debugLog')) {
    function debugLog($msg){
        if (!defined('LOG_ADDRESS')) {
            define('LOG_ADDRESS','../');
        }

        $address = LOG_ADDRESS.'/debug/';
        
        // $address = Yii::getAlias("@runtime") .'/debug/';

        $time = date('Y-m-d H:i:s');
        if(file_exists($address)){
            file_put_contents($address.date("Ymd").".log","[".$time."]".$msg."\r\n",FILE_APPEND);
        }else{
            mkDirs($address);
            chmod($address, 0777);
            file_put_contents($address.date("Ymd").".log","[".$time."]".$msg."\r\n",FILE_APPEND);
        }
    }
}
if (!function_exists('mkDirs')) {
function mkDirs($dir){
    if(!is_dir($dir)){
        if(!mkDirs(dirname($dir))){
            return false;
        }
        if(!mkdir($dir,0777)){
            chmod($dir, 0777);
            return false;
        }
    }
    return true;
}
}


/**
     * 判断当前服务器系统
     * @return string
     */
    if (!function_exists('getOS')) {
     function getOS(){
        if(PATH_SEPARATOR == ':'){
            return 'Linux';
        }else{
            return 'Windows';
        }
    }
    }

/**
     * utf-8和gb2312自动转化
     * @param unknown $string
     * @param string $outEncoding
     * @return unknown|string
     */
     if (!function_exists('safeEncoding')) {
      function safeEncoding($string,$outEncoding = 'UTF-8')
    {
        $encoding = "UTF-8";
        for($i = 0; $i < strlen ( $string ); $i ++) {
            if (ord ( $string {$i} ) < 128)
                continue;
    
            if ((ord ( $string {$i} ) & 224) == 224) {
                // 第一个字节判断通过
                $char = $string {++ $i};
                if ((ord ( $char ) & 128) == 128) {
                    // 第二个字节判断通过
                    $char = $string {++ $i};
                    if ((ord ( $char ) & 128) == 128) {
                        $encoding = "UTF-8";
                        break;
                    }
                }
            }
            if ((ord ( $string {$i} ) & 192) == 192) {
                // 第一个字节判断通过
                $char = $string {++ $i};
                if ((ord ( $char ) & 128) == 128) {
                    // 第二个字节判断通过
                    $encoding = "GB2312";
                    break;
                }
            }
        }
    
        if (strtoupper ( $encoding ) == strtoupper ( $outEncoding ))
            return $string;
        else
            return @iconv ( $encoding, $outEncoding, $string );
    }
}
    
