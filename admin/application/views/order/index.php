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
                <li><a href="#">约课订单 </a></li>
            </ol>
            <form action="/order/index" method="post">
            <div class="self-info">


            <div class="form-inline">
             <div class="form-group">
                        <label class="" for="telphone1">手机号</label>
                        <input type="input" class="form-control"  name="mobile" value="<?php echo $where['mobile'];?>">
                    </div>
                    <div class="form-group">
                        <label class="" for="userName">订单类型</label>
                        <select class="form-control" name="lesson_type" >
                            <option value="">全部</option>
                            <?php foreach ($lessonType as $key => $value) {?>
                                <option value="<?php echo $key;?>" <?php if("$key"===$where['lesson_type']) echo "selected"; ?>><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    </div>
                     <div class="form-group">
                        <label class="" for="userName">付款类型</label>
                        <select class="form-control" name="payment_type" >
                            <option value="">全部</option>
                             
                                <option value="1" <?php if(1==$where['payment_type']) echo "selected"; ?>>微信</option>
                                <option value="2" <?php if(2==$where['payment_type']) echo "selected"; ?>>精练计划</option>
                            
                        </select>
                    </div>
                    
            </div>
            <div class="db"></div>
            <div class="form-inline">
             <div class="form-group">
                        <label class="" for="userName">场地</label>
                        <select class="form-control" name="site_id" >
                            <option value="">全部</option>
                            <?php foreach ($site as $key => $value) {?>
                                <option value="<?php echo $value['site_id'];?>" <?php if($value['site_id']===$where['site_id']) echo "selected"; ?>><?php echo $value['site_name'];?></option>
                            <?php }?>
                        </select>
                    </div>
            <div class="form-group">
                    <label class="" for="telphone1">老师</label>
                    <select class="form-control" name="teacher_id" >
                            <option value="">全部</option>
                            <?php foreach ($teacher as $key => $value) {?>
                                <option value="<?php echo $value['teacher_id'];?>" <?php if($value['teacher_id']===$where['teacher_id']) echo "selected"; ?>><?php echo $value['teacher_name'];?></option>
                            <?php }?>
                        </select>
            
                </div>
           
                 <div class="form-group">
                        <label class="" for="telphone1">订单号</label>
                        <input type="input" class="form-control"  name="order_sn" value="<?php echo $where['order_sn'];?>">
                    </div>  
                   
            </div>        
<div class="db"></div>
            <div class="form-inline">
                <div class="form-group">
                    <label class="" for="">订单时间</label>
                    <input type="input" class="form-control " id="startDate"    name="startDate"   value="<?php echo $where['startDate']; ?>">
                    至<input type="input" class="form-control" id="endDate"    name="endDate" value="<?php echo $where['endDate']; ?>">
                </div>
                <div class="form-group">
                    <label class="" for="">上课时间</label>
                    <input type="input" class="form-control " id="courseStartDate"    name="courseStartDate"   value="<?php echo $where['courseStartDate']; ?>">
                    至<input type="input" class="form-control" id="courseEndDate"    name="courseEndDate" value="<?php echo $where['courseEndDate']; ?>">
                </div>
                <div class="db"></div>
            </div> 

<div class="form-inline">

                         <div class="form-group">
                        <label class="" for="userName">订单状态</label>
                        <select class="form-control" name="payment_state" >
                            <option value="">全部</option>
                             <?php foreach ($status as $key => $value) {?>
                                <option value="<?php echo $key;?>" <?php if("$key"===$where['payment_state']) echo "selected"; ?>><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    </div>
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo '/order/exportOrder?' . http_build_query($where) ?>" class="btn btn-primary">导出</a>
            <div class="db"></div>

                </div>  
                 </form>
            <div class="db"></div>

    <div class="table-responsive " style="white-space: nowrap;">
        <?php if (!empty($data)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>订单号</th>
                    <th>昵称</th>
                    <th>手机号</th>
                    <!-- <th>课程</th> -->
                    <th>老师</th>
                    <th>场地</th>
                    <th>课程/类型</th>
                    <th>上课时间</th>
                    <th>下单日期</th>
                    <th>支付方式</th>
                    <th>实付</th><!-- 
                    <th>优惠</th>
                    <th>实付</th> -->
                    
                    <th>状态</th>
                    
                    <!-- <th>操作</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { if($item['payment_state']>3){$item['payment_state']=3;}?>
                    <tr>
                        
                        <td><?php echo $item['order_sn']; ?></td>
                        <td><?php echo $item['nickname']; ?></td>
                        <td><?php echo $item['mobile']; ?></td>
                        <!-- <td> -->
                            <?php //echo $item['lesson_name']; ?>
                        <!-- </td> -->
                        <td><?php echo $item['teacher_name']; ?></td>
                        <td><?php echo $item['site_name']."<br>".$item['classroom_name']; ?></td>
                        <td>
                            <?php echo $item['lesson_name']."<br>(".$lessonType[$item['lesson_type']].")"; ?>
                        </td>
                        <td><?php echo $item['course_date'].' '.$item['begin_time']; ?></td>
                        <td>
                            <?php 
                            echo substr($item['create_time'], 0, strpos($item['create_time'], ' '));
                            ?>
                        </td>
                        
                        <td><?php echo $paymentType[$item['payment_type']]; ?></td>
                        <td>
                            <?php echo "课价：".$item['total_price']; ?>
                            
                        <!-- </td>
                        <td> -->
                            <?php echo "<br>优惠：".$item['deduction_price']; ?>
                        <!-- </td>
                        <td> -->
                            <?php echo "<br><b>实付：".$item['actual_price']."</b>"; ?>
                        </td>
                       
                        <td><?php echo $status[$item['payment_state']]; ?></td>
                       
                        <td>
                         <?php if($item['payment_state']==4){?>

                         <?php $content = '<div class="xingxing">';
                            $content .= '评价内容：<textarea class="form-control" rows="3" >'.$item['evaluate_content'].'</textarea>';
                            $es = str_repeat('<li>★</li>',$item['evaluate_service']) . str_repeat('<li>☆</li>',5-$item['evaluate_service']);
                            $ee = str_repeat('<li>★</li>',$item['evaluate_envir']) .str_repeat('<li>☆</li>',5-$item['evaluate_envir']);
                            $et = str_repeat('<li>★</li>',$item['evaluate_teacher']) . str_repeat('<li>☆</li>',5-$item['evaluate_teacher']);
                            $content .= '<p>场馆服务：<ul class="wuxing comment">'.$es.'</ul></p>';
                            $content .= '<p>场馆环境：<ul class="wuxing comment">'.$ee.'</ul></p>';
                            $content .= '<p>老师服务：<ul class="wuxing comment">'.$et.'</ul></p>';
                             $content .= "</div>";
                         ?>
                        <input  value="查看评价" class="btn btn-primary" type="button" id="showJuge" 
                        data='<?php echo $content?>'>
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
    <style>
       
        .comment {
            font-size: 30px;
            color: #505656;
        }
        .xingxing p{
            clear: both;
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
    $(function(){
        $("#showJuge").on('click', showJuge);


        function showJuge(){
            var content = $(this).attr('data');
            
            layer.open({
                        title: "查看评价",
                        area: ["500px", "500px"],
                        btn: ["确认"],
                        content: content,
                        
                        yes: function (index) {
                             layer.close(index);                 
                          

                        }
                    });

        }
    })


$(function () {
    $('#startDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
    $('#endDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

    $('#courseStartDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
    $('#courseEndDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

})




    </script>
  
<?php $this->load->view("public/footer"); ?>
