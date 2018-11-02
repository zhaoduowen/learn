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
                <li><a href="#">首页设置管理 </a></li>
                <li class="active">品牌专访列表</li>
            </ol>
            <form action="/ad/index" method="post">
            <div class="self-info">
                <div class="form-inline">
                    
                <div class="form-group">
                    <label class="" for="keyword">类型</label>
                     <select class="form-control" name="postion_id" id="postion_id">
                                <option value="">请选择</option>
                                <?php foreach ($typeArr as $key=>$item) { ?>
                                    <option
                                        value="<?php echo $key; ?>" <?php if($where['type'] == $key){ echo  "selected" ;}?>><?php echo $item ?></option>
                                <?php } ?>
                            </select>
                    
                </div>
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"  type="button" onclick="location.href='/sethome/brand_add'">新增品牌专访</button>
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
                    <th>排序</th>
                    <th>类型</th>
                    <th>标题</th>
                    <th>图片</th>

                    <th>链接</th>
                    <th>是否上架</th>
                    

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        <td><?php echo $item['ordern']; ?></td>
                        <td><?php echo $typeArr[$item['type']]; ?></td>
                        <td><?php echo $item['title']; ?></td>
                        <td><img width="50px" height="50px;" src="<?php echo G_IMAGE_DOMAIN.$item['img_url']; ?>"></td>
                        
                        <td><?php echo $item['link_url']; ?></td>

                        <td><?php if($item['status'] == 1){
                        echo "上架";
                        }else{
                        echo "下架";
                        } ?></td>
                        
                       
                        <td>
                        <input  value="编辑" class="btn btn-primary" type="button" onclick="location.href='/sethome/modify_brand?ad_id=<?php echo $item['set_id'] ?>'">
                        <input class="btn btn-primary" type="button"
                            onclick="del(<?php echo $item['set_id'] ?>)"
                    
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
                    url: "/ad/operation",
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
