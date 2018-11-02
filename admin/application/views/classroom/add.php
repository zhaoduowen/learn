<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <!-- <li><a href="#">教室管理 </a></li> -->
                <li class="active">新增教室</li>
            </ol>

            <form class="form-horizontal">
                <input type="hidden" id="site_id" value="<?php echo $site['site_id']?>">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>场地名称</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入场地名称" id="site_name" value="<?php echo $site['site_name']?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>教室</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入教室" id="classroom_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>场地人数</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入场地人数" id="classroom_people_num">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="" class="col-sm-2 control-label"></label>

                    <div class="col-sm-9">
                        <div id="timetableList"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" onclick="addTime()">添加时间区域</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" id="addSaveBtn">保存</button>
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>
<div id="timeSelect" style="display:none">
<div class="form-inline li">
 <select class="begin_time">
    <?php foreach ($timeList as $key => $value) {
        echo "<option value='{$value}'>".$value.'</option>';
    }?>
</select>
--
<select class="end_time">
    <?php foreach ($timeList as $key => $value) {
        echo "<option value='{$value}'>".$value.'</option>';
    }?>
</select>
<a class="redbtn" href="javascript:;" onclick="$(this).parent().remove();">删除</a></div>
</div>
    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/classroom.js"></script>
<?php $this->load->view("public/footer"); ?>

<script type="text/javascript">

    new AjaxUpload(
        '#uploadPicBtn',
        {action: '/upfile/index',
            name: 'uploadfile',
            autoSubmit: true,
            responseType: 'json',
            data: {
                typeinfo : '<?php echo G_UPLOAD . '/infomation'; ?>'
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
                        +"<input type='hidden' name='sitePic' value='"+response.imageurl+"'/>"
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
 
</script>




