<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">精练计划管理 </a></li>
                <li class="active">编辑精练计划</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="<?php echo $data['plan_id']?>" id="plan_id">
              <div class="db"></div>
                    <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label"><span class="text-red">*</span>头图</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success">
                         <div class="img-item">
                                    <input type='hidden' name='plan_pic' value='<?php echo $data['plan_pic'];?>'/>    
                                    <img src="<?php echo G_IMAGE_DOMAIN.$data['plan_pic'];?>" width="100" height="100" alt="" class="img-rounded">
                                    <div class="control-img">
<!--                                        <a class="text-white" href="javascript:;" onclick="delPic(this)">重传</a>-->
                                        <a class="text-white" href="javascript:;" onclick="delPic(this)">删除</a>
                                    </div>
                                </div>
                        
                        </div>

                            <div class="add-img" id="uploadPicBtn">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                       
                    </div>
                </div>
                 <div class="db"></div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>精练计划名称</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入精练计划名称" id="plan_name" value="<?php echo $data['plan_name']?>">
                    </div>
                </div>



                <div class="form-group">
                        <label for="inputPush6" class="col-sm-2 control-label"><span class="text-red">*</span>课程类型</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="plan_type">
                                
                                 <?php foreach ($type as $key => $value) {?>
                                    <option value="<?php echo $key;?>" <?php if($data['plan_type']==$key){ echo "selected"; }?>><?php echo $value;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                 <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>精品小班课</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="次数" id="plan_num_cg" value="<?php echo $data['plan_num_cg']?>">
                    </div>
                </div>
                
                 <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>私教课</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="次数" id="plan_num_sj" value="<?php echo $data['plan_num_sj']?>">
                    </div>
                </div>

                 <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>伙伴课</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="次数" id="plan_num_xz" value="<?php echo $data['plan_num_xz']?>">
                    </div>
                </div>  
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>有效天数</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="" id="plan_length" value="<?php echo $data['plan_length']?>">
                    </div>
                </div>  

                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>市场价</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control moneyInput" placeholder="" id="plan_market_price" value="<?php echo $data['plan_market_price']?>">
                    </div>
                </div>  


                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>销售价</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control moneyInput" placeholder="" id="plan_price" value="<?php echo $data['plan_price']?>">
                    </div>
                </div>  

                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>默认购买人数</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="" id="plan_buy_num" value="<?php echo $data['plan_buy_num']?>">
                    </div>
                </div>    

                    <!-- <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label">轮播图</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success1">
                       <?php if ($data['planPic']) {
                                foreach ($data['planPic'] as  $k=>$p){?>
                                
                                
                                <div class="img-item">
                                    <input type='hidden' name='planPic' value='<?php echo $p['pic_path'];?>'/>    
                                    <img src="<?php echo G_IMAGE_DOMAIN.$p['pic_path'];?>" width="100" height="100" alt="" class="img-rounded">
                                    <div class="control-img">
                                        <a class="text-white" href="javascript:;" onclick="delPic(this)">删除</a>
                                    </div>
                                </div>
                            <?php }}?>
                        
                        </div>

                            <div class="add-img" id="uploadPicBtn1">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                       
                    </div>
                </div> -->
                 <div class="db"></div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">精练计划简介</label>

                    <div class="col-sm-9">
                        <script id="container" name="content" type="text/plain">
                         <?php echo $data['plan_content'];?>
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
                    <label for="" class="col-sm-2 control-label">注意事项</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" id="plan_remind"><?php echo $data['plan_remind']?></textarea>
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


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/plan.js"></script>
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
                typeinfo : '<?php echo G_UPLOAD . '/plan'; ?>'
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
                        +"<input type='hidden' name='plan_pic' value='"+response.imageurl+"'/>"
                        +'<img src="<?php echo G_IMAGE_DOMAIN; ?>'+response.imageurl+'" width="100" height="100" alt="" class="img-rounded">'
                        +'<div class="control-img">'
                        +' <a class="text-white" href="javascript:;" onclick="delPic(this)">删除</a>'
                        +'</div>'
                        +'</div>';

                    $("#uploadPic_success").append(str);

                }
            }
        });

new AjaxUpload(
        '#uploadPicBtn1',
        {action: '/upfile/index',
            name: 'uploadfile',
            autoSubmit: true,
            responseType: 'json',
            data: {
                typeinfo : '<?php echo G_UPLOAD . '/plan'; ?>'
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
                        +"<input type='hidden' name='planPic' value='"+response.imageurl+"'/>"
                        +'<img src="<?php echo G_IMAGE_DOMAIN; ?>'+response.imageurl+'" width="100" height="100" alt="" class="img-rounded">'
                        +'<div class="control-img">'
                        +' <a class="text-white" href="javascript:;" onclick="delPic(this)">删除</a>'
                        +'</div>'
                        +'</div>';

                    $("#uploadPic_success1").append(str);

                }
            }
        });


    function delPic(delbtn){
        $(delbtn).parents('.img-item').remove();
    }
 
</script>
