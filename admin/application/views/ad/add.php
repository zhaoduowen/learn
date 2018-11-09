<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">广告管理 </a></li>
                <li class="active">添加广告</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="" id="ad_strength">
            
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>广告标题</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入广告标题" id="title">
                    </div>
                </div>
               <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label"><span class="text-red">*</span>图片(600*860)</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success">
                       
                        
                        </div>

                            <div class="add-img" id="uploadPicBtn">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                       
                    </div>
                </div>
                 <div class="db"></div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>广告链接</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请广告链接" id="link_url" >
                    </div>
                </div>
                 <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>是否上架</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" checked> 是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status"  value="2" > 否
                            </label>
                             
                        </div>
                    </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>排序号</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="排序号" id="ordernNum" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">备注</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" id="ad_remark"> </textarea>
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


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/ad.js"></script>
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
                typeinfo : '<?php echo G_UPLOAD . '/ad'; ?>'
            },
            onChange: function(file, extension){
                // var picNum = $("#uploadPic_success").find(".img-item").length;
                // if(picNum >=1){
                //     showError( '最多上传1张图片' );
                //     return false;
                // }
            },
            onSubmit: function(file, extension) {

            },
            onComplete: function(file, response) {

                if(response.status!='undefined'&&response.status==0){
                    $("#uploadPic_error").text(response.mess);
                }else{
                    $("#uploadPic_error").text("");
                    var str='<div class="img-item">'
                        +"<input type='hidden' name='adPic' value='"+response.imageurl+"'/>"
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

