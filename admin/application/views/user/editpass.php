 <?php  $this->load->view('public/header');?>

 <form class="form-horizontal" method="POST" action="/user/editpass?id=<?php echo $info['id'];?>" onsubmit="return checkUserForm();">
<div class="main col-sm-9 col-md-10 ">
            <div class="bgf">
            <ol class="breadcrumb">
                   
                    <li class="active">修改账号密码</li>
                </ol>
            
               
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">账号名称：</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="请输入账号名称" name="JzOperAdmin[username]" id="JzOperAdmin_username" value="<?php echo $info['username'];?>" disabled>
                        </div>
                    </div>

                   
                    
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">修改密码</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="请输入修改密码" name="password" id="JzOperAdmin_password" value="">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="请输入确认密码" name="confirm_pass" id="JzOperAdmin_confirmPass" value="">

                        </div>
                    </div> 


 

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9">
                           
                             <button type="submit" class="btn btn-primary" >修改账号密码</button>
                        </div>
                    </div>
                
                    <div class="db"></div>
                    <div class="db"></div>
                
 
            </div>
             
</div>
</form>



<?php $this->load->view('public/footer');?>
<script type="text/javascript">
    function checkUserForm(){
        
        var password = $("#JzOperAdmin_password").val();
        var confirm_pass = $("#JzOperAdmin_confirmPass").val();
      
        if( password =='' ){
            showError('修改密码不能为空');
            return false;
        }
        if (password.length < 6) {
            showError('修改密码长度6位以上');
            return false;
        }
        if( confirm_pass =='' ){
            showError('确认密码不能为空');
            return false;
        }
        if( password != confirm_pass ){
            showError('修改密码和确认密码不一致');
            return false;
        }
        
        
    }

</script>