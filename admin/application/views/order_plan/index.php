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
                <li><a href="#">计划订单 </a></li>
            </ol>
            <form action="/orderPlan/index" method="post">
            <div class="self-info">


            <div class="form-inline">
                    <div class="form-group">
                        <label class="" for="userName">计划类型</label>
                        <select class="form-control" name="plan_type" >
                            <option value="">全部</option>
                            <?php foreach ($planType as $key => $value) {?>
                                <option value="<?php echo $key;?>" <?php if("$key"===$where['plan_type']) echo "selected"; ?>><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    </div>
                     <div class="form-group">
                        <label class="" for="telphone1">订单号</label>
                        <input type="input" class="form-control"  name="order_sn" value="<?php echo $where['order_sn'];?>">
                    </div>
                    <div class="form-group">
                        <label class="" for="userName">订单状态</label>
                        <select class="form-control" name="payment_state" >
                            <option value="">全部</option>
                             <?php foreach ($status as $key => $value) {?>
                                <option value="<?php echo $key;?>" <?php if("$key"===$where['payment_state']) echo "selected"; ?>><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    </div>
                   
            </div>
            <div class="db"></div>
            <div class="form-inline">
            
                    <div class="form-group">
                            <label class="" for="">订单时间</label>
                            <input type="input" class="form-control " id="startDate"    name="startDate"   value="<?php echo $where['startDate']; ?>">
                        
                            
                            至<input type="input" class="form-control" id="endDate"    name="endDate" value="<?php echo $where['endDate']; ?>">
                        </div>
              
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo '/orderPlan/exportOrderPlan?' . http_build_query($where) ?>" class="btn btn-primary">导出</a>
            <div class="db"></div>

                </div>  </form>
            <div class="db"></div>

    <div class="table-responsive " style="white-space: nowrap;">
        <?php if (!empty($data)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>订单号</th>
                    <th>用户</th>
                    <th>计划名称</th>
                    <th>计划权益</th>
                    <th>销售价</th>
                    <th>优惠</th>
                    <th>实付</th>
                    <th>时间</th>
                  
                    <th>状态</th>
                    
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                         <td><?php echo $item['order_sn']; ?></td>
                        <td>
                        <?php echo '昵称：'.$item['nickname'].'<br>

                            手机号：'.$item['mobile'];?>

                        </td>
                        <td><?php echo $item['plan_name']; ?></td>
                        <td><?php echo $planType[$item['plan_type']]; ?></td>
                        <td><?php echo $item['total_price']; ?></td>
                        <td><?php echo $item['deduction_price']; ?></td>
                        <td><?php echo $item['actual_price']; ?></td>
                        <td><?php echo $item['create_time']; ?></td>
                        
                        
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

})




    </script>
  
<?php $this->load->view("public/footer"); ?>
