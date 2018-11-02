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
                <li><a href="#">场地管理 </a></li>
                <li class="active">新增场地</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" id="lng">
            <input type="hidden" id="lat">
            <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label"><span class="text-red">*</span>场地图片(680*320)</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success">
                            <div class="add-img" id="uploadPicBtn">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>场地名称</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入场地名称" id="site_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>场地地址</label>

                    <div class="col-sm-9">
                    <div class="form-inline">
                                 
                    <input  style="width: 350px;" type="text" class="form-control" placeholder="请输入场地地址" id="site_address">
                     &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;"  id="baiduMap">地图</a>
                    </div>

                        
                    <div id="location" style="
                margin-top:30px; 
                width: 500px; 
                height: 450px; 
                border: 1px solid gray;
                overflow:hidden;
                display:none;"></div>  
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>联系电话</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入联系电话" id="site_mobile">
                    </div>
                </div>

                 <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>课程类型</label>
                        <div class="col-sm-9">
                         <?php foreach ($type as $key=>$item) { ?>
                          <label class="checkbox-inline">
                                <input  class="checkbox" type="checkbox" value="<?php echo $key ?>" name="lesson_type_limit[]"> <?php echo $item?>
                            </label>
                        <?php } ?>
                          
                        
 
                             
                        </div>
                    </div>
                <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>课程</label>
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
                    <label for="" class="col-sm-2 control-label">场地介绍</label>

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
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">备注</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" id="site_remark"></textarea>
                    </div>
                </div>
               
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" id="addSiteBtn">保存</button>
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/site.js"></script>
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
                typeinfo : '<?php echo G_UPLOAD . '/site'; ?>'
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

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=kQBp7OFazTXpuIiLTDaoIuLvsIUpzlnI"></script>

 <script>
 $(function(){

    $("#baiduMap").on('click',showMap);
    $("#site_address").on('blur',searchByStationName);
    function showMap(){
         $("#location").toggle();
         searchByStationName();
    }

 })
    // 百度地图API功能
    var map = new BMap.Map("location");
    map.centerAndZoom("北京", 12);
    map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

    map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
    map.addControl(new BMap.OverviewMapControl()); //添加默认缩略地图控件
    map.addControl(new BMap.OverviewMapControl({ isOpen: true, anchor: BMAP_ANCHOR_BOTTOM_RIGHT }));   //右下角，打开

    var localSearch = new BMap.LocalSearch(map);
    localSearch.enableAutoViewport(); //允许自动调节窗体大小
 function searchByStationName() {

    map.clearOverlays();//清空原来的标注
    var keyword = document.getElementById("site_address").value;
    if (keyword=='') {alert('请输入场地地址');return false;};
    localSearch.setSearchCompleteCallback(function (searchResult) {
        var poi = searchResult.getPoi(0);
        $("#lng").val(poi.point.lng);
        $("#lat").val(poi.point.lat);
        
        map.centerAndZoom(poi.point, 13);
        var marker = new BMap.Marker(new BMap.Point(poi.point.lng, poi.point.lat));  // 创建标注，为要查询的地址对应的经纬度
        map.addOverlay(marker);
    });
    localSearch.search(keyword);
} 

 </script>
