<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo W_STATIC_URL; ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo W_STATIC_URL; ?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo W_STATIC_URL; ?>css/nuoyh.css">
    <link rel="stylesheet" href="<?php echo W_STATIC_URL; ?>css/login.css">
    <script src="<?php echo W_STATIC_URL; ?>js/jquery/jquery-1.11.3.min.js"></script>
    <script src="<?php echo W_STATIC_URL; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- 日历插件 -->
    <script src="<?php echo W_STATIC_URL; ?>bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo W_STATIC_URL; ?>bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
    <!-- 日历插件 -->
    <!-- 弹出插件 -->
    <script src="<?php echo W_STATIC_URL; ?>js/sco/sco.msgsage.js"></script>
    <script src="<?php echo W_STATIC_URL; ?>js/layer/layer.js"></script>
    <!--[if lt IE 9]>
      <script src="<?php echo W_STATIC_URL; ?>js/ltie9/html5shiv.min.js"></script>
      <script src="<?php echo W_STATIC_URL; ?>js/ltie9/respond.min.js"></script>
    <![endif]-->
    <style>
        .flex{
            width: 100%;
            display:inline-block;
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="bg"></div>
    <div class="form-horizontal">

            <h3>登录</h3>
          <div class="form-group">
              <input type="input" class="form-control" id="username" placeholder="账号" value="<?php if($_COOKIE['zhimei_remember']==1): echo $_COOKIE['zhimei_remember_username'];endif;?>">
          </div>
          <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="密码" value="<?php if($_COOKIE['zhimei_remember']==1): echo $_COOKIE['zhimei_remember_password'];endif;?>">
              
            <div class="col-sm-9"> <label class="checkbox-inline">
                 <input type="checkbox" class="checkbox" name="remember" id="remember" value="1" <?php if($_COOKIE['zhimei_remember']==1): echo 'checked';endif;?> style="height:15px;"><span style="margin-left:5px;">记住密码</span><a href="/user/findpass" style=" margin-left:30px;color: #f97e29;">忘记密码？</a>
                               
                </label>
                             
                        </div>

             

          </div>
           <!-- <div class="form-group">
            <div class="col-sm-9">
              <input type="text" class="form-control" id="captcha_code" placeholder="验证码">
            </div>
            <div class="col-sm-3">
               <img class="" height="40" width="100%"  src="<?php echo site_url('/user/captcha');?>" onclick='this.src="<?php echo site_url('/user/captcha')?>?r="+Math.random();' alt="" />
            </div>
          </div> -->
        
          <div class="form-group">
               
                  <button class="btn btn-block btn-primary btn-lg" onclick="loginBtnEvt()">登录</button>
          </div>


    </div>
</div>
 
</body>
</html>

<script type="text/javascript">
    function loginBtnEvt(){
   
        username = $.trim( $( '#username' ).val() );
        password = $.trim( $( '#password' ).val() );
        var remember = $("#remember").is(':checked');
        
        if(remember==true){
            remember = 1; 
        }else{
            remember = 0; 
        }
        // captcha_code = $.trim( $( '#captcha_code' ).val() );
     
    if( username =='' ){
        showError( '账号不能为空' );
        return false;
    }

    if( password =='' ){
        showError( '密码不能为空' );
        return false;
    }
    // if(captcha_code==''){
    // 	showError('验证码不能为空');
    // 	return false;
    // }
   
    $.ajax({
        url: '/user/actionlogin',
        type:'POST',
        data:{
            username: username,
            password:password,
            remember:remember,
            // captcha_code:captcha_code,
            
        },
        dataType:'json'
    }).done(function( data ) {
        if( data.status == 200 ){

                window.location.href = '/index';
            
        } else if(data.status == 301){/*密码超过90天的强制改密码*/
           
            
            $('#userName').val($('#username').val()) //将登录页的密码写入
        }  else{
            showError( data.msg );
            
        }
        //console.log( data );
    }).fail( function (){

      
    })

}

function forgetPass()
{
    layer.open({
                title: [
                    '忘记密码！',
                    'border-bottom:1px solid #ccc;background-color:#e1e1e1;'
                ],
                content: ''
                + '<input class="flex" id="userName" type="text" placeholder="帐户名或手机号" name="">'
                + '<input class="flex" id="originPassword" type="password" placeholder="原密码" name="">'
                + '<input class="flex" id="newPassword" type="password" placeholder="新密码" name="">'
                + '<input class="flex" id="confirmPassword" type="password" placeholder="确认密码" name="">',
                closeBtn: 0,
                btn: ['取消', '立即修改'],
                yes: function(index){
                    layer.close(index);
                },
                btn2: function (index, dom) {
                    var originUseName = $.trim($('#userName').val()),
                        originPwd = $.trim($('#originPassword').val()),
                        oldPwd = $.trim( $( '#password' ).val() ),
                        newPwd = $.trim($('#newPassword').val()),
                        confirmPwd = $.trim($('#confirmPassword').val());
                    if(originUseName == '') {
                        showError('账号不能为空')
                        return false;
                    }
                    if(originPwd == '') {
                        showError('原密码不能为空')
                        return false;
                    }
                    
                    if(newPwd == '') {
                        showError('新密码不能为空')
                        return false;
                    }
                    if(newPwd == originPwd) {
                        showError('新密码不能和原密码相同')
                        return false;
                    }
                    if(confirmPwd != newPwd) {
                        showError('两次密码输入不一致')
                        return false;
                    }
                    var _this = this;
                    $.ajax({
                        url: '/user/forceEditpass',
                        type:'POST',
                        data:{
                            username: originUseName,
                            oldpass: originPwd,
                            password: newPwd,
                            confirm_pass: confirmPwd
                        },
                        dataType:'json'
                    }).done(function (data) {
                        if(data.status == 1) {
                            layer.close(index);
                            
                        } else {
                            showError(data.msg);
                            layer.open(_this);
                            $('#userName').val($('#username').val());
                            return false;
                        }
                    })

                }
            });
}



</script>