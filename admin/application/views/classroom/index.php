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
                <li><a href="#">场地管理 </a></li>
                <li class="active">场地列表</li>
            </ol>
            <form action="/classroom/index" method="post">
            <div class="self-info">
                <div class="form-inline">
                    
                <div class="form-group">
                    <label class="" for="keyword">场地名称</label>
                    <input type="input" class="form-control"  name="keyword"
                           value="<?php echo $where['keyword'] ?>" placeholder="关键字">
                </div>
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"  type="button" onclick="location.href='/classroom/add'">新增场地</button>
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
                    <th>场地名称</th>
                    <th>地址</th>
                    <th>联系电话</th>
                    <th>教室</th> 
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        
                        <td><?php echo $item['site_name']; ?></td>
                        <td><?php echo $item['site_address']; ?></td>
                        <td><?php echo $item['site_mobile']; ?></td>
                       

                        <td><?php if(!empty($item['classroom'])){
                            foreach ($item['classroom'] as $k => $v) {
                                echo "<a href='/classroom/edit?id=".$v['classroom_id']."'>".$v['classroom_name']."</a>&nbsp;&nbsp;";
                        }} ?></td>
                        <td>
                        <input  value="添加教室" class="btn btn-primary" type="button" onclick="location.href='/classroom/add'">
                        <input  value="编辑" class="btn btn-primary" type="button" onclick="location.href='/site/modify?site_id=<?php echo $item['site_id'] ?>'">
                        <input class="btn btn-primary" type="button"
                            onclick="del(<?php echo $item['site_id'] ?>)"
                    
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
                    url: "/site/operation",
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