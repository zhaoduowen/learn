<?php $this->load->view('public/header'); ?>
<div class="main col-sm-9 col-md-10 ">
    <div class="bgf">
        <ol class="breadcrumb">
            <li><a href="#">资讯管理 </a></li>
            <li class="active">新增资讯</li>
        </ol>

        <form class="form-horizontal">
            <input type="hidden" value="<?php echo $data['web_infomation_id'];?>" id="web_infomation_id">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">资讯标题</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="请输入资讯标题" id="title" value="<?php echo $data['title'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">资讯类型</label>

                <div class="col-sm-9">
                    <select class="form-control" name="web_infomation_type" id="web_infomation_type">
                        <option value="0">请选择资讯类型</option>
                        <?php foreach ($type as $item) { ?>
                            <option
                                value="<?php echo $item['web_infomation_type']+1; ?>" <?php if($item['web_infomation_type'] == $data['web_infomation_type']){ echo "selected";}?>><?php echo $item['description'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">概要</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="请输入概要" id="outline" name="outline" value="<?php echo $data['outline'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">关键字</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="请输入关键字" id="keywords" name="keywords" value="<?php echo $data['keywords'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">是否是外部资讯</label>

                <div class="col-sm-9" id="radioBox">
                    <label class="radio-inline">
                        <input type="radio" name="flag_out_site" value="1" <?php if($data['flag_out_site'] == 1){ echo "checked"; }?>> 是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="flag_out_site" value="0" <?php if($data['flag_out_site'] == 0){ echo "checked"; }?>> 否
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">外部咨询url</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="请输入外部咨询url" id="out_site_url"
                           name="out_site_url" value="<?php echo $data['out_site_url']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPush10" class="col-sm-2 control-label">缩略图</label>

                <div class="col-sm-9 file-img">
                    <div id="uploadPic_success">
                        <?php if($data['thumb_img_url'] != ''){?>
                        <div class="img-item">
                            <input type='hidden'  name='infomationPic' value='<?php echo $data['thumb_img_url'];?>'/>
                            <img src="<?php echo G_IMAGE_DOMAIN.$data['thumb_img_url'];?>" width="100" height="100" alt="" class="img-rounded">
                            <div class="control-img">
                                <!--	                                    <a class="text-white" href="javascript:;" onclick="delPic(this)">重传</a>-->
                                <a class="text-white" href="javascript:;" onclick="delPic(this)">删除</a>
                            </div>
                        </div>
                        <?php }?>
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
                        <?php echo $data['content'];?>
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

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">是否推荐</label>

                <div class="col-sm-9" id="radioBox">
                    <label class="radio-inline">
                        <input type="radio" name="flag_recommend" value="1" <?php if($data['flag_recommend'] == 1){ echo "checked"; }?>> 是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="flag_recommend" value="0" <?php if($data['flag_recommend'] == 0){ echo "checked"; }?>> 否
                    </label>
                </div>
            </div>


             <div class="form-group" id="appFindModule"  <?php if($data['web_infomation_type'] != 7){?>style="display:none;"<?php }?>>
                        <label class="col-sm-2 control-label">有效期</label>
                        <div class="col-sm-9">
                            <div class="form-inline">
                                 
                                <input type="text" class="form-control date-push" id="begin_time" placeholder="开始日期" value="<?php echo $data['begin_time']; ?>">
                                
                                至
                             
                                <input type="text" class="form-control date-push" id="end_time" placeholder="结束日期" value="<?php echo $data['end_time']; ?>">
                                 
                            </div>
                        </div>
                    </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9 ">
                    <button class="btn btn-primary" type="button" id="addInfomationBtn">确认修改保存</button>
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
                typeinfo : '<?php echo G_UPLOAD . '/home'; ?>'
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
        })



       
         $('#begin_time').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii:ss',
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            minView: 0
        });



          $('#end_time').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii:ss',
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            minView: 0
        });
    })
</script>
