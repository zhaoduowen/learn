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
                <li><a href="#">自选排课 </a></li>
                <li class="active">排课列表</li>
            </ol>
            <form action="/teacherCourse/index" method="get">
            <div class="self-info">


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
                    <label class="" for="">日期</label>
                    <input type="input" class="form-control " id="startDate"   name="course_date"   value="<?php echo $where['course_date']; ?>">
                </div>
              
                <button class="btn btn-primary"  type="submit">查询</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"  type="button" onclick="location.href='/teacherCourse/add'">新增排课</button>
            </div>
            <div class="db"></div>
           
                </div>  </form>
            <div class="db"></div>
    <div class="table-responsive " style="white-space: nowrap;">
        <?php if (!empty($data)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>日期</th>
                    <th>场地</th>
                    <th>教室</th>
                    <th>老师</th>
                    <!-- <th>课程类型</th> -->
                    <th>时间区域</th>
                    <!-- <th>课程</th> -->
                    
                    <!-- <th>约课人数</th> -->
                    
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        
                        
                        <td><?php echo $item['course_date']; ?></td>
                        <td><?php echo $item['site_name']; ?></td>
                        <td><?php echo $item['classroom_name']; ?></td>
                        <td><?php echo $item['teacher_name']; ?></td>
                        <!-- <td><?php echo $lessonType[$item['lesson_type']]; ?></td> -->
                        <td ><span data="
                                <?php if(!empty($item['timetable'])){
                            foreach ($item['timetable'] as $k => $v) {
                                echo $v['begin_time'].'-'.$v['end_time']."<br>";
                        }} ?>
                            " class="viewTime">查看</span></td>
                       
                       <!-- <td><?php echo $item['lesson_name']; ?></td> -->
                       
                       <!-- <td><?php echo $item['appoint_people_num'].'/'.$item['classroom_people_num']; ?></td> -->
                        <td>
                          
                        <input  value="编辑" class="btn btn-primary" type="button" onclick="location.href='/teacherCourse/modify?course_id=<?php echo $item['course_id'] ?>'">
                         <input  value="删除" class="btn btn-primary" type="button" onclick="del(<?php echo $item['course_id'] ?>)">
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
                    url: "/teacherCourse/operation",
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




$(function () {
    $(".viewTime").on('click',function(){
        layer.alert($(this).attr('data'));
    });


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
