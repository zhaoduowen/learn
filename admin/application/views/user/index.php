<?php  $this->load->view('public/header');?>
<div class="main col-sm-9 col-md-10 ">
            <div class="bgf">

                <ol class="breadcrumb">
                    <li><a href="#">权限管理 </a></li>
                    <li class="active">账号管理</li>
                </ol>
                <div class="self-info">
                    <div class="form-inline">
                    <form method="GET" >
                        <div class="form-group">
                            <label class="" for="telphone1">账号名称</label>
                            <input type="input" class="form-control" id="" placeholder="账号名称"  name='username' value='<?php echo $request['username'];?>'>
                        </div>
                        <div class="form-group">
                            <label class="" for="userName">手机号码</label>
                            
                            <input type="input" class="form-control"  placeholder="请输入手机号码"  name='mobile' value='<?php echo $request['mobile'];?>'>
                        </div>
                        <div class="form-group">
                            <label class="" for="userName">真实姓名</label>
                            
                            <input type="input" class="form-control" id="endDate" placeholder="姓名"  name='realname' value='<?php echo $request['realname'];?>'>
                        </div>

                    </div>
                    <div class="db"></div>
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="" for="">账号角色 </label>
                            <select class="form-control" name="role_id" id="">
                                <option value="">全部</option>
                                <?php foreach ($roleList as $key => $value) {?>
                                    <option value="<?php echo $value['id'];?>" <?php if($value['id']==$request['role_id']) echo "selected"; ?>><?php echo $value['name'];?></option>
                                <?php }?>
                            </select>
                             
                        </div>
                        <div class="form-group">
                            <label class="" for="">账号状态 </label>
                            <select class="form-control" name="state" id="">
                                <option value="">全部</option>
                                <option value="1" <?php if('1'==$request['state']) echo "selected"; ?>>激活</option>
                                <option value="0" <?php if('0'==$request['state']) echo "selected"; ?>>停用</option>
                            </select>
                        </div>
                         <button class="btn btn-primary" type="submit">查询</button>
                    </div>
                    <div class="db"></div>
                    <div class="db"></div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>账号名称</th>
                                <th>真实姓名</th>
                                <th>手机号码</th>
                                <th>账号角色</th>
                                <th>账号状态</th>
                                <th>管理</th>
                                 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($list) && !empty($list)) {
                                foreach ($list as $v) {
                                    ?>
                                    <tr>
                                        <td><?php echo $v['id'];?></td>
                                        <td><?php echo $v['username'];?></td>
                                        <td><?php echo $v['realname'];?></td>
                                        <td><?php echo $v['mobile'];?></td>
                                       
                                        <td><?php echo $v['rolename'];?></td>
                                        <td><?php if ($v['state'] == '1') {
                                            echo "激活";
                                        } elseif ($v['state'] == '0') {
                                            echo "停用";
                                        } else {
                                            echo "其他";
                                        } ?></td>
                                       
                                        <td>
                                            <a  class="successbutton" href="/user/edit?id=<?php echo $v['id'];?>">修改</a>&emsp;
                                            <?php if ($v['state'] == '1') {?>
                                            <a href="javascript:void(0)" onclick="updateState(<?php echo $v['id'];?>,0)" class="text-warning">锁定</a>&emsp;
                                            <?php }?>
                                            <?php if ($v['state'] == '0') {?>
                                            <a href="javascript:void(0)" onclick="updateState(<?php echo $v['id'];?>,1)" class="text-warning">启用</a>&emsp;
                                            <?php }?>
                                            <a href="javascript:void(0)" onclick="updateState(<?php echo $v['id'];?>,-1)" lass="text-danger">删除</a>&emsp;
                                            <?php if ($v['id']==$_SESSION['yoyoga_uid']) {?>
                                               <a href="/user/editpass?id=<?php echo $v['id'];?>" class="successbutton">密码</a>
                                             <?php }?>
                                            
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            
                             
                        </tbody>
                    </table>


                    <div class="text-center">
                         <?php echo $pagination; ?>
                    </div>  
                </div>
 
            </div>
             
</div>
    

<script>
function updateState(id,state){
  if (!confirm('你确定要进行此操作吗？')) {return false;};  
  $.ajax({
    type:'post',
    url:"/user/updateState",
    data:{'id':id,'state':state},
    dataType:'json',
    success:function(rs){
      if(rs.success==1)
      {
        window.location.reload();
      }else{
        alert(rs['mes']);
      }
    }
  }); 
}
</script>


<?php $this->load->view('public/footer');?>