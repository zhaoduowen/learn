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
                <li><a href="#">课程管理 </a></li>
                <li class="active">课程列表</li>
            </ol>
            <form action="/lesson/index" method="post">
            <div class="self-info">
                <div class="form-inline">
                    
                <div class="form-group">
                    <label class="" for="keyword">课程名称</label>
                    <input type="input" class="form-control"  name="keyword"
                           value="<?php echo $where['keyword'] ?>" placeholder="关键字">
                </div>
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"  type="button" onclick="location.href='/lesson/add'">新增课程</button>
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
                    <th>课程名称</th>
                    <th>课程类型</th>
                    <th>课程强度</th>
                    <th>课程价格</th>
                    
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        
                        <td><?php echo $item['lesson_name']; ?></td>
                        <td><?php echo $type[$item['lesson_type']]; ?></td>
                        <td><?php echo str_repeat('★',$item['lesson_strength']); ?></td>
                        <td><?php echo $item['lesson_price']; ?></td>
                        <td>
                        
                        <input  value="编辑" class="btn btn-primary" type="button" onclick="location.href='/lesson/modify?lesson_id=<?php echo $item['lesson_id'] ?>'">
                        <input class="btn btn-primary" type="button"
                            onclick="del(<?php echo $item['lesson_id'] ?>)"
                    
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
                    url: "/lesson/operation",
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