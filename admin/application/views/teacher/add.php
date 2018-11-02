<?php $this->load->view('public/header'); ?>
<style type="text/css">
.timetableli{    
    padding-bottom: 20px;
    margin: 10px;
    float: left;
    width: 900px;
    border-bottom: 1px #b9b3b3 solid;
}
    .timetableli .siname{font-size:17px;padding-right:200px;}
    .timetableli div{padding-top:10px;padding-left: 10px;width: 210px;display:block;float:left;    border: 1px #b9b3b3 solid;    margin-left: 10px;}
    .timetableli ul{list-style:none;width: 200px;}

</style>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">老师管理 </a></li>
                <li class="active">新增老师</li>
            </ol>

            <form class="form-horizontal">
            <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label"><span class="text-red">*</span>头像</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success">
                            <div class="add-img" id="uploadPicBtn">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>老师名称</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入老师名称" id="teacher_name">
                    </div>
                </div>
             

                <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>适用场地</label>
                
                    <div class="col-sm-9">
                        <div class="timetableli">
                            <ul>
                               <?php foreach ($site as $key => $value): ?>
        <li><input  type="checkbox" name="change_site_name[]" value='<?php echo $value['site_id']?>'><?php echo $value['site_name']?></li>
    <?php endforeach ?>
</ul>

                        </div>
                    </div>
                </div>
                 


                <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>适用课程</label>
                         <div class="col-sm-9">
                         <div class="timetableli">
                    <?php if(!empty($newLesson)){foreach ($newLesson as $key=>$rows) { ?>
                    <div class="selectLessonClass">
                    <p><b><?=$lessonType[$key]?></b></p>
                    
                         <ul>   
                         <?php if(!empty($rows)){foreach ($rows as $k=>$item) { ?>
                          <li>
                                <input  type="checkbox" value="<?php echo $item['lesson_id'] ?>" name="lesson_arr[]"> <?php echo $item['lesson_name']?>
                            </li>
                        <?php }} ?>
                         </ul>
                         </div>  
                       
                        <?php }} ?>
                        </div>
                            
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>老师特长</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" id="teacher_sign" max-length="30"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>老师电话</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入老师电话" id="teacher_mobile">
                    </div>
                </div>
                    
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">老师详情</label>

                    <div class="col-sm-9">
                        <script id="container" name="content" type="text/plain">
                        </script>
                        <!-- 配置文件 -->
                        <script type="text/javascript"
                                src="<?php echo W_STATIC_URL; ?>UEditor/ueditor.config.js"></script>
                        <!-- 编辑器源码文件 -->
                        <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>UEditor/ueditor.all.js"></script>
                        <!-- 实例化编辑器 -->
                        <script type="text/javascript">
                            var ue = UE.getEditor('container');
                        </script>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="" class="col-sm-2 control-label">备注</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" id="teacher_remark"></textarea>
                    </div>
                </div> -->
               
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" id="addSaveBtn">保存</button>
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/teacher.js"></script>
<?php $this->load->view("public/footer"); ?>
<script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/jquery.ajaxupload.js"></script>
<!--上传-->
<script type="text/javascript">

    new AjaxUpload(
        '#uploadPicBtn',
        {action: '/upfile/index',
            name: 'uploadfile',
            autoSubmit: true,
            responseType: 'json',
            data: {
                typeinfo : '<?php echo G_UPLOAD . '/teacher'; ?>'
            },
            onChange: function(file, extension){
                var picNum = $("#uploadPic_success").find(".img-item").length;
                if(picNum >=1){
                    showError( '最多上传1张图片' );
                    return false;
                }
            },
            onSubmit: function(file, extension) {

            },
            onComplete: function(file, response) {

                if(response.status!='undefined'&&response.status==0){
                    $("#uploadPic_error").text(response.mess);
                }else{
                    $("#uploadPic_error").text("");
                    var str='<div class="img-item">'
                        +"<input type='hidden' name='teacherPic' value='"+response.imageurl+"'/>"
                        +'<img src="<?php echo G_IMAGE_DOMAIN; ?>'+response.imageurl+'" width="100" height="100" alt="" class="img-rounded">'
                        +'<div class="control-img">'
                        +' <a class="text-white" href="javascript:;" onclick="delPic(this)">删除</a>'
                        +'</div>'
                        +'</div>';

                    $("#uploadPic_success").append(str);

                }
            }
        });
    function delPic(delbtn){
        $(delbtn).parents('.img-item').remove();
    }
 
function showSiteTime(sid){
    $.ajax({
                    url: '/teacher/getSite',
                    type: 'POST',
                    dataType: 'json',
                    data:{site_id:sid},
                    beforeSend:function(){//请求之前执行函数
                        $("body").append('<div class="pload">正在加载...</div>');
                      },
                     complete: function() {//请求之后执行函数
                        $(".pload").remove();
                     },
                    success: function(data){
                      /*  console.log( data );*/
                        if (data.status == 1 ) {
                         var tmpArr = [];
                         var str = '';
                         var content = '';
                          $.each(data.result, function(index, val) {
                                str = '<div class="timetableli">';
                                str +='<p><span class="siname">'+val.site_name+'</span><span onclick="$(this).parent().parent().remove()">删除</span></p>';
                                if(val.classroom.length>0){
                                $.each(val.classroom, function(ic, iv) {    
                                    str +='<div><h5>'+iv.classroom_name+'</h5>'
                                        +'<ul>';
                                    $.each(iv.timetable, function(ti, tv) {
                                        str  +=  '<li><input type="checkbox" name="timetable_name" value="'+tv.timetable_id+'">'+tv.begin_time+'-'+tv.end_time+'</li>';
                                    });

                                    str  += '</ul></div>';
                                 });
                                }
                                
                                str  += '</div>';
                                content += str;

                          });
                          $("#timetableList").append(content);
                        }else{
                            
                            showError( data.msg );
                            return false;
                        }
                    }
                });
}

function addSite(){
    // var content = '';
    // var siteJson = <?php echo json_encode($site)?>;
    // $.each(siteJson, function(index, val) {
    //     content +='<input  type="checkbox" name="change_site_name" value='+val.site_id+'>'+val.site_name+"<br>";
        

    //   });
    content = $("#selectSiteId").html();
    layer.open({
                title: "适用场地",
                area: ["400px", "500px"],
                btn: ["确认"],
                content: content,
                
                yes: function (index) {
                    var room_pid=[];
                    $("input[type='checkbox'][name='change_site_name']:checked").each(function(){
                        room_pid.push($(this).val());
                    });
                    var site_ids = room_pid.join(",");
                    if(site_ids){
                        showSiteTime(site_ids);
                    }
                    
                   layer.close(index);

                }
            });

}


</script>

<div id="selectSiteId" style="display:none">
    <?php foreach ($site as $key => $value): ?>
        <input  type="checkbox" name="change_site_name" value='<?php echo $value['site_id']?>'><?php echo $value['site_name']?><br>
    <?php endforeach ?>
</div>



