<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">用户管理 </a></li>
                <li class="active">查看用户详情</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="<?php echo $data['uid'];?>" id="uid">
            <div class="form-group">
                    <label for="inputPush10" class="col-sm-2 control-label">头像</label>

                    <div class="col-sm-9 file-img">
                        <div id="uploadPic_success">
                        <?php if($data['avatar'] != ''){?>
                        <div class="img-item">
                            
                            <img src="<?php echo $data['avatar'];?>" width="100" height="100" alt="" class="img-rounded">
                            
                        </div>
                        <?php }?>

                       
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">用户ID</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control"   id="site_name" value="<?php echo $data['uid']?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">昵称</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="<?php echo $data['nickname']?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">手机号</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control"    value="<?php echo $data['mobile']?>" readonly>
                    </div>
                </div>
 <div class="form-group">
                    <label for="" class="col-sm-2 control-label">性别</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control"   value="<?php echo $data['sex']==1?'男':'女'?>" readonly>
                    </div>
                </div>

 <div class="form-group">
                    <label for="" class="col-sm-2 control-label">生日</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['birthday']?>" readonly>
                    </div>
                </div>

 <div class="form-group">
                    <label for="" class="col-sm-2 control-label">身高</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['height']?>" readonly>
                    </div>
                </div>
<div class="form-group">
                    <label for="" class="col-sm-2 control-label">体重</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['weight']?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">公司</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['company_name']?>" readonly>
                    </div>
                </div>
 <div class="form-group">
                    <label for="" class="col-sm-2 control-label">职务</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['job']?>" readonly>
                    </div>
                </div>
 <div class="form-group">
                    <label for="" class="col-sm-2 control-label">约课次数</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['orderCount']?>次" readonly>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="" class="col-sm-2 control-label">优惠券</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['useBonusCount'].'/'.$data['bonusCount']?>" readonly>
                        <button class="btn " type="button" onclick="showBonus()">查看</button>
                    </div>
                </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label">精练计划</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['planCount']?>" readonly>
                        <button class="btn " type="button"  onclick="showPlan()">查看</button>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="" class="col-sm-2 control-label">注册时间</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['create_time']?>" readonly>
                    </div>
                </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label">最后登录时间</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['login_time']?>" readonly>
                    </div>
                </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label">首次上课时间</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['firstTime']?>" readonly>
                    </div>
                </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label">流失天数</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="site_mobile"  value="<?php echo $data['loseDay']?>" readonly>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" onclick="history.go(-1)">返回</button>
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/site.js"></script>
<?php $this->load->view("public/footer"); ?>

<style type="text/css">
.ulshow{
    line-height: 35px;
    height: 35px;
        clear: both;
}
.ulshow ul li{
   
    list-style-type: none;
    background-color: #eeefe7;
    border-right-width: 1px;
    border-right-style: solid;

    float: left;

    padding-right: 5px;
    margin: 2px;
}


</style>

<div id="selectId" style="display:none">
 
    <?php if ($data['bonus']) {
         foreach ($data['bonus'] as $item) { ?>
                   <div class="ulshow">
                       <ul> 
                        <li><?php echo $item['begin_date'].'至'.$item['end_date']; ?></li>
                        <li><?php echo $item['status']=='2'?'已使用': ($item['status']=='1'?'未使用':'已过期'); ?></li>
                        <li><?php echo $item['amount']; ?></li>
                        <li><?php echo $type[$item['bonus_type']] ;?></li>
                        <li><?php echo $item['use_time']; ?></li>
                      </ul> 
                    </div>  
                <?php }}?>


</div>
<div id="selectId2" style="display:none">
  
    <?php if ($data['plan']) {
         foreach ($data['plan'] as $item) { ?>
                    <div class="ulshow">
                       <ul> 
                <li style="width:100px"><?php echo $item['plan_name']; ?></li>        
                <li><?php echo $item['begin_time'].'至'.$item['begin_time']; ?>有效</li>
                <li><?php echo $item['plan_type']=='1'?'个人':'企业'; ?></li>
                <li><?php echo '
精品小班课：'.$item['plan_num_cg'].'<br>

私教课：'.$item['plan_num_sj'].'<br>

伙伴课：'.$item['plan_num_xz'];?></li>
                 </ul> </div> 
        <?php }}?>

</ul>
</div>
<script type="text/javascript">
function showBonus(){
    var content = $("#selectId").html();
    layer.open({
                title: "优惠券",
                area: ["600px", "450px"],
                btn: ["确认"],
                content: content,
                
                yes: function (index) {
                   layer.close(index);                   
                  

                }
            });

}
 function showPlan(){
    var content = $("#selectId2").html();
    layer.open({
                title: "精练计划",
                area: ["700px", "600px"],
                btn: ["确认"],
                content: content,
                
                yes: function (index) {
                   layer.close(index);                   
                  

                }
            });

}
</script>



