<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">资讯管理 </a></li>
                <li class="active">新增资讯</li>
            </ol>

            <form class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">资讯标题</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入资讯标题" id="title">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">资讯类型</label>

                    <div class="col-sm-9">
                        <select class="form-control" name="web_infomation_type" id="web_infomation_type">
                            <option value="0">请选择资讯类型</option>
                            <?php foreach ($type as $item) { ?>
                                <option
                                    value="<?php echo $item['web_infomation_type']+1; ?>"><?php echo $item['description'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">概要</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入概要" id="outline" name="outline">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">关键字</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入关键字" id="keywords" name="keywords">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">是否是外部资讯</label>

                    <div class="col-sm-9" id="radioBox">
                        <label class="radio-inline">
                            <input type="radio" name="flag_out_site" value="1"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="flag_out_site" value="0" checked> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">外部咨询url</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入外部咨询url" id="out_site_url"
                               name="out_site_url">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label">缩略图</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success">
                            <!--
                                  <div class="img-item">
                                      <img src="https://www.liduoduo.com/public/images/index/ad_pic1.jpg" width="100" height="100" alt="" class="img-rounded">
                                      <div class="control-img">
                                          <a class="text-white" href="">重传</a>
                                          <a class="text-white" href="">删除</a>
                                      </div>
                                  </div>-->

                            <div class="add-img" id="uploadPicBtn">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">资讯正文</label>

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
                    <label for="" class="col-sm-2 control-label">上线状态</label>

                    <div class="col-sm-9" id="radioBox">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1"> 上线
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" checked> 未上线
                        </label>
                    </div>
                </div> -->
                <input type="hidden" name="status" value="0" > 
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">是否推荐</label>

                    <div class="col-sm-9" id="radioBox">
                        <label class="radio-inline">
                            <input type="radio" name="flag_recommend" value="1"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="flag_recommend" value="0" checked> 否
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" id="addInfomationBtn">保存</button>
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/infomation.js"></script>
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
                typeinfo : '<?php echo G_UPLOAD . '/infomation'; ?>'
            },
            onChange: function(file, extension){
                var picNum = $("#uploadPic_success").find(".img-item").length;
                if(picNum >=1){
                    showError( '最多上传1张咨询图片' );
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
                        +"<input type='hidden' name='infomationPic' value='"+response.imageurl+"'/>"
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
    $(function(){
        $("#web_infomation_type").change(function(){
            var pt = $("#web_infomation_type" ).val();
            if(pt==8){
                $("#appFindModule").show();
            }else{
                $("#appFindModule").hide();
            }

            if(pt==4){
                $('#out_site_url').val('<?php echo WWW_URL.'h5/notice/info_details'?>');
            }else{
                $('#out_site_url').val('');
            }
        })

    })
</script>



