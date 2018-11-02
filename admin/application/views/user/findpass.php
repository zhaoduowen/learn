<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>忘记密码</title>
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

            <h3>忘记密码</h3>
          <div class="form-group">
              <input type="input" class="form-control phoneNum" id="username" placeholder="手机号">
          </div>

           <div class="form-group">
            <div class="col-sm-9">
              <input type="text" class="form-control code"  placeholder="短信验证码">
              
            </div>
<div class="col-sm-3">
              <button class="btn btn-block btn-primary getCode" style="height:40px;">获取验证码</button>
            </div>
          </div>
 <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="密码">

          </div>
           <div class="form-group">
                       <input type="password" class="form-control" placeholder="确认密码" name="confirm_pass" id="confirm_pass" value="">

                    </div> 
          <br>
          <div class="form-group">
                  <button class="btn btn-block btn-primary btn-lg" onclick="loginBtnEvt()">确认</button>
          </div>


    </div>
</div>
 
</body>
</html>

<script src="<?php echo W_STATIC_URL;?>js/sendCode.js"></script>

<script type="text/javascript">
    $( '.getCode' ).on('click' , function (){//点击获取验证码
        $( this ).sendCode({
            mobile : $( '.phoneNum' ).val(),
            type:'post',
            url:'/user/SmsVerificationCode',
            data:{
                mobile:$( '.phoneNum' ).val(),
            }
        });
    })

    </script>
<script type="text/javascript">
    function loginBtnEvt(){
   
        username = $.trim( $( '#username' ).val() );
        password = $.trim( $( '#password' ).val() );
        confirm_pass = $.trim( $( '#confirm_pass' ).val() );
         var code = $( '.code' ).val();
       
    if( username =='' ){
        showError( '手机号不能为空' );
        return false;
    }

    if( password =='' ){
        showError( '密码不能为空' );
        return false;
    }

    if(confirm_pass != password) {
        showError('两次密码输入不一致')
        return false;
    }
        if (code == '') {
            showError('验证码不能为空');
            return false;
        }

        if (code.length != 6 || isNaN(code)) {
            showError('验证码必须为6位数字');
            return false;
        }

        $.ajax({
            url: '/user/checkCode',
            type: 'POST',
            dataType: 'json',
            data:{mobile:username,mobileCode:code},
            success: function(data){
                if (data.status == 1 ) {


                    $.ajax({
                        url: '/user/forceEditpass',
                        type:'POST',
                        data:{
                            username: username,
                            password:password,
                            confirm_pass:confirm_pass,
                        },
                        dataType:'json'

                    }).done(function( res ) {
                        if( res.status == 1 ){

                        window.location.href = '/index';
                    
                        } else{

                            showError( res.msg );
                            return false;
                            
                        }
        //console.log( data );
    }).fail( function (){
                showError( data.msg );
                      
                    })

                }else{
                     showError( data.msg );
                            return false;
                }
            }
        })

}

</script>