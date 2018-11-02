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
                <li><a href="#">优惠券管理 </a></li>
                <li class="active">优惠券列表</li>
            </ol>
            <form action="/bonus/index" method="post">
            <div class="self-info">
                <div class="form-inline">
                    
                <div class="form-group">
                    <label class="" for="keyword">优惠券名称</label>
                    <input type="input" class="form-control"  name="keyword"
                           value="<?php echo $where['keyword'] ?>" placeholder="关键字">
                </div>
                 <div class="form-group">
                        <label for="" class="">课程类型</label>
                            <select class="form-control" name="type" id="type">
                                <option value="">请选择</option>
                                <?php foreach ($type as $key=>$item) { ?>
                                    <option
                                        value="<?php echo $key; ?>" <?php if($where['type'] == $key){ echo  "selected" ;}?>><?php echo $item ?></option>
                                <?php } ?>
                            </select>
                        </div>
                <div class="form-group">
                        <label for="" class="">发放类型</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">请选择</option>
                                <?php foreach ($category as $key=>$item) { ?>
                                    <option
                                        value="<?php echo $key; ?>" <?php if($where['category'] == $key){ echo  "selected" ;}?>><?php echo $item ?></option>
                                <?php } ?>
                            </select>
                        </div>
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"  type="button" onclick="location.href='/bonus/add'">新增优惠券</button>
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
                    <th>ID</th>
                    <th>标题</th>
                    <th>金额</th>
                    <th>课程类型</th>
                    <th>有效时间</th>
                    <th>发放类型</th>
                    <th>发放数量</th> 
                    <th>使用数量</th> 
                    <th>生成时间</th> 
                    <!-- <th>生成人</th>  -->
                    <th>优惠券备注</th> 
                    <th>状态</th> 
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        
                        <td><?php echo $item['bonus_id']; ?></td>
                        <td><?php echo $item['bonus_name']; ?></td>
                        <td><?php echo $item['amount']; ?></td>
                        <td><?php echo $type[$item['bonus_type']] ;?></td>
                        <td><?php echo $item['term_days']; ?></td>
                        <td><?php echo $category[$item['category']] ;?></td>
                        
                        <td><a href="/bonus/sendlist?bonus_id=<?php echo $item['bonus_id'] ?>"><?php echo $item['sent_num']; ?></a></td>
                        <td><a href="/bonus/uselist?bonus_id=<?php echo $item['bonus_id'] ?>"><?php echo $item['use_num']; ?></a></td>

                        <td><?php echo date("Y-m-d",strtotime($item['create_time'])); ?></td>
                        <!-- <td> -->
                            <?php //echo $item['admin_name']; ?>
                                
                        <!-- </td> -->
                        <td><?php echo mb_strlen($item['description'])>10?mb_substr($item['description'],0,9,"utf-8").""."...":$item['description']; ?></td>
                        <td><?php if($item['status'] == 1){
                        echo "启用";
                        }else{
                        echo "<p style='background:#bbb;'>停用</p>";
                        } ?></td>

                        
                        <td>
                       <!-- <input  value="编辑" class="btn btn-primary" type="button" onclick="location.href='/site/modify?bonus_id=<?php echo $item['bonus_id'] ?>'"> -->
                       
                        <?php if($item['status'] == 1){?>
                        <input  value="停用" class="btn btn-primary" type="button" onclick="handle(<?php echo $item['bonus_id']?>,0)">
                        <!-- <input  value="查看详情" class="btn btn-primary" type="button" onclick="location.href='/bonus/modify?bonus_id=<?php echo $item['bonus_id'] ?>'"> -->

                         <?php if($item['category'] == 3){?>
                        <input class="btn btn-primary" type="button" onclick="sendOne(<?php echo $item['bonus_id'] ?>)" value="发放" >    
                        <input class="btn btn-primary" type="button" onclick="sendBatch(<?php echo $item['bonus_id'] ?>)" value="批量发放" >    
                        <?php }?>

                        <?php }else{?>
                         <input  value="启用" class="btn btn-primary" type="button" onclick="handle(<?php echo $item['bonus_id']?>,1) ">
                         <!-- 
                         <input  value="编辑" class="btn btn-primary" type="button" onclick="location.href='/bonus/modify?bonus_id=<?php echo $item['bonus_id'] ?>'">
 -->
                        <?php }?>
 
                                            
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
<script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/jquery.ajaxupload.js"></script>
<!--上传-->
<script type="text/javascript">
function loadU(){
    new AjaxUpload(
        '#uploadPicBtn',
        {action: '/upfile/uploadfile',
            name: 'uploadfile',
            autoSubmit: true,
            responseType: 'json',
            data: {
                typeinfo : '<?php echo G_UPLOAD . '/bonus'; ?>'
            },
            onChange: function(file, extension){
               
            },
            onSubmit: function(file, extension) {

            },
            onComplete: function(file, response) {
               
                if(response.status!='undefined'&&response.status==0){
                    showError(response.mess);
                    return false;
                }else{
                    $("#fileName").val(response.file_path);
                    var str='<p><?php echo G_IMAGE_DOMAIN; ?>'+response.file_path+'</p>';

                    $("#uploadPic_success").html(str);
                    showSuccess('上传成功');
                    return false;

                }
            }
        });
    }
    function delPic(delbtn){
        $(delbtn).parents('.img-item').remove();
    }    
   
        function del(id){
            if (!confirm('你确定要删除吗？')) {return false;}
            $.ajax({
                    type: 'POST',
                    url: "/bonus/operation",
                    data: {'id': id},
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

        function handle(id,status){

            $.ajax({
                    type: 'POST',
                    url: "/bonus/handle",
                    data: {'id': id,'status':status},
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

function sendOne(bonus_id){
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
                        url: '/bonus/send',
                        type: 'POST',
                        dataType: 'json',
                        data:{sendMobile:sendMobile,bonus_id:bonus_id},
                        success: function(data){
                         
                            if (data.status == 1 ) {
                               $.scojs_message('发放成功', $.scojs_message.TYPE_OK);
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

function sendBatch(bonus_id){
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
                        url: '/bonus/sendBatch',
                        type: 'POST',
                        dataType: 'json',
                        data:{fileName:fileName,bonus_id:bonus_id},
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