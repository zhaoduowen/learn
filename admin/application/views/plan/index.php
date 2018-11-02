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
                <li><a href="#">精练计划管理 </a></li>
                <li class="active">精练计划列表</li>
            </ol>
            <form action="/plan/index" method="post">
            <div class="self-info">
                <div class="form-inline">
                    
                <div class="form-group">
                    <label class="" for="keyword">精练计划名称</label>
                    <input type="input" class="form-control"  name="keyword"
                           value="<?php echo $where['keyword'] ?>" placeholder="关键字">
                </div>
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"  type="button" onclick="location.href='/plan/add'">新增精练计划</button>
                </div>
                <div class="db"></div>
                
                    </div>
                </div>  </form>
                <div class="db"></div>
    <div class="table-responsive " style="white-space: nowrap;">
        <?php if (!empty($data)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>精练计划名称</th>
                    <th>类型</th>
                    <th>价格</th>
                    <th>次数</th>
                    <th>有效天数</th>
                    <th>累计销售数量</th>


                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        
                        <td><?php echo $item['plan_name']; ?></td>
                        <td><?php echo $type[$item['plan_type']]; ?></td>
                        <td><?php echo '市场价：￥'.$item['plan_market_price'].'<br>销售价：￥'.$item['plan_price'];?></td>
                        <td><?php echo '
精品小班课：'.$item['plan_num_cg'].'<br>

私教课：'.$item['plan_num_sj'].'<br>

伙伴课：'.$item['plan_num_xz'];?></td>
                       
                       <td><?php echo $item['plan_length']; ?></td>
                       <td><?php echo $item['saleNum']; ?></td>
                        <td>
                        
                        <input  value="编辑" class="btn btn-primary" type="button" onclick="location.href='/plan/modify?plan_id=<?php echo $item['plan_id'] ?>'">
                        <input class="btn btn-primary" type="button"
                            onclick="del(<?php echo $item['plan_id'] ?>)"
                    
                            value="删除" >
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
    <script>
        function del(id){
            if (!confirm('你确定要删除吗？')) {return false;}
            $.ajax({
                    type: 'POST',
                    url: "/plan/operation",
                    data: {'id': id},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 1) {
                            $.scojs_message('操作成功', $.scojs_message.TYPE_OK);
                            setTimeout(function () {
                                window.location = window.location;
                            }, 3000);
                        } else {
                            $.scojs_message('操作失败', $.scojs_message.TYPE_ERROR);
                            setTimeout(function () {
                                window.location = window.location;
                            }, 3000);
                        }
                    }
                })
        }
    </script>
  
<?php $this->load->view("public/footer"); ?>