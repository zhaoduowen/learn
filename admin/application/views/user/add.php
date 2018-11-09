 <?php  $this->load->view('public/header');?>

<div class="main col-sm-9 col-md-10 ">
            <div class="bgf">
            <ol class="breadcrumb">
                    <li><a href="#">权限管理</a></li>
                    <li class="active">添加账号</li>
                </ol>
                <form class="form-horizontal" method="POST" action="/user/add" id="form" >


                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">账号名称：</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="请输入账号名称" name="JzOperAdmin[username]" id="JzOperAdmin_username">
                        </div>
                    </div>
 <div class="form-group">
                        <label for="" class="col-sm-2 control-label">手机号码：</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="请输入手机号码" name="JzOperAdmin[mobile]" id="JzOperAdmin_mobile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">账号密码：</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="请输入密码" name="JzOperAdmin[password]" id="JzOperAdmin_password">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">真实姓名：</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="请输入真实姓名" name="JzOperAdmin[realname]" id="JzOperAdmin_realname">

                        </div>
                    </div>

                   <!--  <div class="form-group">
                        <label for="" class="col-sm-2 control-label">账号角色：</label>
                        <div class="col-sm-9">
                        <?php foreach ($roleList as $key => $value) {?>
                            <label class="radio-inline">
                                <input type="radio" name="JzOperAdmin[role_id]" value="<?php echo $value['id'];?>"> <?php echo $value['name'];?>
                            </label>
                        <?php }?>
                           

                        </div>
                    </div>  -->

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">账号状态：</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" name="JzOperAdmin[status]" value="1" checked="checked"> 激活
                            </label>

                            <label class="radio-inline">
                                <input type="radio" name="JzOperAdmin[status]" value="0"> 停用  
                            </label>
                             

                        </div>
                    </div>

 

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9 ">
                           
                             <button type="button" class="btn btn-primary" onclick=" checkUserForm();">添加账号</button>
                        </div>
                    </div>
                
                    <div class="db"></div>
                    <div class="db"></div>
                
                </form>
            </div>
             

</div>



<?php $this->load->view('public/footer');?>
<script type="text/javascript">
var error = "<?php echo $error;?>";
if(error){
    showError(error);
}
    function checkUserForm(){
        var username = $("#JzOperAdmin_username").val();
        var mobile = $("#JzOperAdmin_mobile").val();
        var password = $("#JzOperAdmin_password").val();
        var realname = $("#JzOperAdmin_realname").val();
        var role_id = $("input[name='JzOperAdmin\[role_id\]']:checked" ).val();
       
        if( username =='' ){
            showError('账号名称不能为空');
            return false;
        }
        var mobile = $("#JzOperAdmin_mobile").val();
        if (mobile == "") {
            showError('手机号不能为空');
            return false;
        }
        var mobile_reg = /^1[3|4|5|8|7][0-9]\d{8}$/;
        if (!mobile_reg.test(mobile)) {
            showError('手机号格式错误');
            return false;
        }

        if( password =='' ){
            showError('账号密码不能为空');
            return false;
        }
        if (password.length < 6) {
            showError('账号密码长度6位以上');
            return false;
        }
        if( realname =='' ){
            showError('真实姓名不能为空');
            return false;
        }
        if( password =='' ){
            showError('账号密码不能为空');
            return false;
        }
        // if (role_id == undefined) {
        //     showError('请选择账号角色');
        //     return false;
        // }

        $.ajax({
            url: '/user/add',
            type:'POST',
            data:$("#form").serialize()+"&json=1",
            dataType:'json'
        }).done(function (data) {
            if(data.status == 1) {
                location.href="/user/index"
            } else {
                showError(data.msg);
               
                return false;
            }
        })
        
    }

</script>