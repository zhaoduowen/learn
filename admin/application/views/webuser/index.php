<?php $this->load->view('public/header'); ?>
<style type="text/css">
    .main .self-info .form-group label{
        width:90px;
    }
    .input-group{
        width: 220px;
        margin-left: 5px;
    }
</style>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">用户管理 </a></li>
                <li class="active">用户列表</li>
            </ol>
            <form action="/webuser/index" method="post">
            <div class="self-info">
                <div class="form-inline">
                    <div class="form-group">
                        <label class="" for="telphone1">手机号</label>
                        <input type="input" class="form-control"  name="mobile" value="<?php echo $where['mobile'];?>">
                    </div>
                 <div class="form-group">
                            <label class="" for="">注册日期</label>
                            <input type="input" class="form-control " id="startDate"    name="startDate"   value="<?php echo $where['startDate']; ?>">
                        
                            
                            至<input type="input" class="form-control" id="endDate"    name="endDate" value="<?php echo $where['endDate']; ?>">
                        </div>
                <div class="db"></div>
                <br>        
                 <div class="form-group">
                        <label for="" class="">获取方式</label>
                            <select class="form-control" name="share_user_id" id="share_user_id">
                                <option value="">请选择</option>
                                    <option
                                        value="1" <?php if($where['share_user_id'] == 1){ echo  "selected" ;}?>>转介绍</option>
                                              <option
                                        value="2" <?php if($where['share_user_id'] == 2){ echo  "selected" ;}?>>正常注册</option>
                            </select>
                        </div>
<!-- <div class="form-group">
                        <label for="" class="">用户状态</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">请选择</option>
                                <?php foreach ($status as $key=>$item) { ?>
                                    <option
                                        value="<?php echo $key; ?>" <?php if($where['status'] == $key){ echo  "selected" ;}?>><?php echo $item ?></option>
                                <?php } ?>
                            </select>
                        </div> -->
                <button class="btn btn-primary"  type="submit">查询</button>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo '/webuser/exportUser?' . http_build_query($where) ?>" class="btn btn-primary">导出</a> 
                </div>
                <div class="db"></div>
                
                    </div>
                </div>  </form>
                <div class="db"></div>
    <div class="table-responsive " style="white-space: nowrap;">
        <?php if (!empty($data)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>用户ID</th>
                    <th>用户昵称</th>
                    <th>手机号</th>
                    <th>性别</th>
                    <th>约课次数</th>
                    
                    <th>注册日期</th> 
                    <th>获取方式</th>
                    <th>首次订单</th> 
                    <th>最后订单</th> 
                    <th>所属场馆</th> 
                    <th>流失天数</th> 
                    <th>推荐人数</th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        
                        <td><?php echo $item['uid']; ?></td>
                        <td><?php echo $item['nickname']; ?></td>
                        <td><?php echo $item['mobile']; ?></td>
                        <td><?php echo $item['sex']==1?'男':'女'; ?></td>
                        <td><?php echo $item['orderCount']; ?></td>
                        <td><?php echo date("Y-m-d",strtotime($item['create_time'])); ?></td>
                        <td><?php echo $item['share_user_id']>0?'转介绍':'正常注册'; ?></td>
                        <td><?php echo date("Y-m-d",strtotime($item['firstCourseTime'])); ?>
                       </td>
                        <td><?php echo date("Y-m-d",strtotime($item['lastCourseTime'])); ?>
                        </td>
                        <td><?php echo $item['site_name']; ?></td>
                        <td><?php echo $item['loseDay']==-1?'未预约':$item['loseDay']; ?></td>
                        <td><?php echo $item['inviter_num']; ?></td>

                        <td>
                        <input  value="查看详情" class="btn btn-primary" type="button" onclick="location.href='/webuser/info?uid=<?php echo $item['uid'] ?>'">
                        <?php if($item['status'] == 1){?>
                       <input class="btn btn-primary" type="button" onclick="hanle(<?php echo $item['uid'] ?>,2)" value="停用" >
                        <?php }else{?>
                         <input class="btn btn-primary" type="button" onclick="hanle(<?php echo $item['uid'] ?>,1)" value="启用" >   <?php }?>
                            </td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "暂无数据";
        }
        ?>
    </div>
    <div class="text-center">
        <ul class="pagination">
            <?php echo $pagination; ?>
        </ul>
    </div>

            <div class="db"></div>
        </div>
    </div>


<?php $this->load->view("public/footer"); ?>

<script type="text/javascript">
        function hanle(id,status){
            if (!confirm('你确定要此操作吗？')) {return false;}
            $.ajax({
                    type: 'POST',
                    url: "/webuser/operation",
                    data: {'uid': id,'status':status},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 1) {
                            $.scojs_message('操作成功', $.scojs_message.TYPE_OK);
                            setTimeout(function () {
                                window.location = window.location;
                            }, 3000);
                        } else {
                            $.scojs_message('操作失败', $.scojs_message.TYPE_ERROR);
                            setTimeout(function () {
                                window.location = window.location;
                            }, 3000);
                        }
                    }
                })
        }


function sendOne(webuser_id){
    var content = '';
    content = '手机号：<input type="text" name="sendMobile">';
    layer.open({
                title: "发放",
                area: ["320px", "220px"],
                btn: ["确认"],
                content: content,
                
                yes: function (index) {
                    var sendMobile = $("input[name='sendMobile']").val();
                    if (sendMobile=='') {showError('手机号不能为空');return false;};
                    $.ajax({
                        url: '/webuser/send',
                        type: 'POST',
                        dataType: 'json',
                        data:{sendMobile:sendMobile,webuser_id:webuser_id},
                        success: function(data){
                         
                            if (data.status == 1 ) {
                                showSuccess('发放成功');
                                layer.close(index);
                                window.location.reload();

                            }else{
                                
                                showError( data.msg );
                                return false;
                            }
                        }
                    });                    
                  

                }
            });

}

function sendBatch(webuser_id){
    var content = '<div><label>批量上传：</label><div><input type="hidden" id="fileName"><div class="col-sm-6 file-img"><div id="uploadPic_success"></div><div class="add-img" id="uploadPicBtn"><span class="glyphicon glyphicon-plus"></span></div></div></div> </div>';
    layer.open({
                title: "发放",
                area: ["320px", "280px"],
                btn: ["确认"],
                content: content,
                
                yes: function (index) {
                    var fileName = $("#fileName").val();
                    if (fileName=='') {showError('上传文件');return false;};
                    $.ajax({
                        url: '/webuser/sendBatch',
                        type: 'POST',
                        dataType: 'json',
                        data:{fileName:fileName,webuser_id:webuser_id},
                        success: function(data){
                         
                            if (data.status == 1 ) {
                                showSuccess('发放成功');
                                layer.close(index);
                                window.location.reload();

                            }else{
                                
                                showError( data.msg );
                                return false;
                            }
                        }
                    });                    
                  

                }
            });
    
    loadU();

}
    </script>

<script type="text/javascript">
    $(function () {
    $('#startDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
    $('#endDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

        $('#courseDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

})




    </script>
  