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
                <li><a href="#">资讯管理 </a></li>
                <li class="active">资讯列表</li>
            </ol>

            
                <div class="db"></div>
    <div class="table-responsive " style="white-space: nowrap;">
        <?php if (!empty($data)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>咨询标题</th>
                    <th>关键字</th>
                    <th>咨询类型</th>
                    <th>是否推荐</th>
                   <!--  <th>上线状态</th> -->
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        <td><a href="/infomation/modify?id=<?php echo $item['web_infomation_id'];?>"><?php echo $item['title']; ?></a></td>
                        <td><?php echo $item['keywords']; ?></td>
                        <td><?php echo $setType[$item['web_infomation_type']] ;?></td>
                        <td><?php if($item['flag_recommend'] == 1){
                        echo "推荐";
                        }else{
                        echo "未推荐";
                        } ?></td>

                        <!-- <td><?php if($item['status'] == 1){
if($item['web_infomation_type'] == 5&&!empty($item['end_time'])&&$item['end_time']<date("Y-m-d H:i:s")){
      echo "未上线";
  }else{
     echo "已上线";
  }
                       
                        }else if($item['status'] == 0){
                        echo "未上线";
                        }else{
                        echo "已下线";
                        } ?>




                    </td> -->


                        <td><?php echo $item['create_time']; ?></td>
                        <td>
                            <input class="btn btn-primary" type="button" value="编辑" data-type="offline" onclick="location.href='/infomation/modify?id=<?php echo $item['web_infomation_id'];?>'">
                                                                            &nbsp;&nbsp;&nbsp;
                                                                            <?php if($item['delete_flag'] == 0){?>
                                                                           <!--  <input class="btn btn-primary" type="button"
                                                                            data-content="<?php echo $item['web_infomation_id'] ?>"
                                                                            name="delete"
                                                                            value="删除" data-type="delete"> -->
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
    <script>
        function deleteNews(id){
            if (!confirm('你确定要下线吗？')) {return false;}
            $.ajax({
                type:'post',
                url:"/news/newsOffline",
                data:{'news_id':id},
                dataType:'json',
                success:function(rs){
                    if(rs.success==1)
                    {
                        window.location.reload();
                    }else{
                        alert(rs['msg']);
                    }
                }
            });
        }
    </script>
    <script>
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
        $(function(){
            $("input[type='button']").click(function(){
                var id = $(this).attr("data-content");
                var type = $(this).attr("data-type");
                var state = '';
                if(type == "offline"){
                    state = 1;//下线
                } if(type == "goOnline"){
                    state = 2;//上线
                } if(type == "delete"){
                    state = 3;//删除
                }
                //alert(type);return false;
                $.ajax({
                    type: 'POST',
                    url: "/infomation/operation",
                    data: {'id': id, 'type': state},
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
            })
        })
    </script>
<?php $this->load->view("public/footer"); ?>