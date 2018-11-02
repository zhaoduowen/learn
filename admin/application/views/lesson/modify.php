<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">课程管理 </a></li>
                <li class="active">编辑课程</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="<?php echo $data['lesson_id'];?>" id="lesson_id">
            <input type="hidden" value="<?php echo $data['lesson_strength'];?>" id="lesson_strength">
            
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>课程名称</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入课程名称" id="lesson_name" value="<?php echo $data['lesson_name']?>">
                    </div>
                </div>
                <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>课程类型</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" name="lesson_type" value="1" <?php if($data['lesson_type']==1){ echo "checked"; }?>> 精品小班课
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="lesson_type"  value="2" <?php if($data['lesson_type']==2){ echo "checked"; }?>> 私教课
                            </label>

                            <label class="radio-inline">
                                <input type="radio" name="lesson_type"  value="3" <?php if($data['lesson_type']==3){ echo "checked"; }?>> 伙伴课
                            </label>
                             
                        </div>
                    </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>时长</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入时长" id="lesson_time_length"  value="<?php echo $data['lesson_time_length']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>课程价格</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control moneyInput" placeholder="请输入课程价格" id="lesson_price"  value="<?php echo $data['lesson_price']?>">
                    </div>
                </div>

                 <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>课程强度</label>
                        <div class="col-sm-9">
                        <ul class="wuxing comment">
                            <li>☆</li>
                            <li>☆</li>
                            <li>☆</li>
                            <li>☆</li>
                            <li>☆</li>
                        </ul>
                          
                        
 
                             
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label">课程主图(680*320)</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success">
                        <?php if ($data['lessonPic']) {
                                foreach ($data['lessonPic'] as  $k=>$p){?>
                                
                                
                                <div class="img-item">
                                    <input type='hidden' name='lessonPic' value='<?php echo $p['pic_path'];?>'/>    
                                    <img src="<?php echo G_IMAGE_DOMAIN.$p['pic_path'];?>" width="100" height="100" alt="" class="img-rounded">
                                    <div class="control-img">
<!--                                        <a class="text-white" href="javascript:;" onclick="delPic(this)">重传</a>-->
                                        <a class="text-white" href="javascript:;" onclick="delPic(this)">删除</a>
                                    </div>
                                </div>
                            <?php }}?>
                        
                        </div>

                            <div class="add-img" id="uploadPicBtn">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">课程简介</label>

                    <div class="col-sm-9">
                        <script id="container" name="content" type="text/plain">
                         <?php echo $data['lesson_content'];?>
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
                        <textarea class="form-control" rows="3" id="lesson_remind"><?php echo $data['lesson_remind'];?></textarea>
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


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/lesson.js"></script>
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
                typeinfo : '<?php echo G_UPLOAD . '/lesson'; ?>'
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
                        +"<input type='hidden' name='lessonPic' value='"+response.imageurl+"'/>"
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



<style>
       
        .comment {
            font-size: 30px;
            color: #505656;
        }

        .comment li {
            float: left;
            cursor: pointer;
        }

        ul {
            list-style: none;
        }
    </style>
 <script>
        $(document).ready(function(){

            var shixin = "★";
            var kongxin = "☆";
            /*var flag = false;//没有点击*/
            $(" .wuxing li").mouseenter(function(){
                /*$(this).text(shixin).prevAll().text(shixin);
                $(this).nextAll().text(kongxin);*/
                $(this).text(shixin).prevAll().text(shixin).end().nextAll().text(kongxin);
            });
            $(".comment").mouseleave(function(){
               /* if(!flag){
                    $("li").text(kongxin);
                }*/
                $(".wuxing li").text(kongxin);
                $(".wuxing .clicked").text(shixin).prevAll().text(shixin);
            });
            $(" .wuxing li").on("click",function(){
               /* $(this).text(shixin).prevAll().text(shixin);
                $(this).nextAll().text(kongxin);
                flag = true;*/
                $(this).addClass("clicked").siblings().removeClass("clicked");
                $("#lesson_strength").val($(this).index()+1);
            });
            var xingxing = $("#lesson_strength").val()-1;
            console.log(xingxing);
            $(" .wuxing li:eq("+xingxing+")").mouseenter().click();
        });
    </script>


