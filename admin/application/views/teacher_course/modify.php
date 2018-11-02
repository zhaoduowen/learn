<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">自选排课 </a></li>
                <li class="active">编辑排课</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="<?php echo $data['course_id']?>" id="course_id">
            <input type="hidden" value="<?php echo $data['classroom_people_num']?>"  id="classroom_people_num">
                <div class="form-group">
                        <label for="inputPush2" class="col-sm-2 control-label"><span class="text-red">*</span>日期</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control date-push" id="course_date"  value="<?php echo $data['course_date']?>">
                        </div>
                    </div>
                 <div class="db"></div>

                   <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>场地</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="site_id" >
                            <option value="">选择场地</option>
                            <?php foreach ($site as $key => $value) {?>
                                <option value="<?php echo $value['site_id'];?>" <?php if($value['site_id']===$data['site_id']) echo "selected"; ?>><?php echo $value['site_name'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>

                <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>教室</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="classroom_id" >
                         <option value="">选择教室</option>
                            <?php foreach ($classroom as $key => $value) {?>
                                <option value="<?php echo $value['classroom_id'];?>" <?php if($value['classroom_id']===$data['classroom_id']) echo "selected"; ?>><?php echo $value['classroom_name'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>选择老师</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="teacher_id" >
                         <option value="">选择老师</option>
                            <?php foreach ($teacher as $key => $value) {?>
                                <option value="<?php echo $value['teacher_id'];?>" <?php if($value['teacher_id']===$data['teacher_id']) echo "selected"; ?>><?php echo $value['teacher_name'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>时间区域</label>
                        <div class="col-sm-9">
                       <div id="timetableList">
                         <ul>
                            <?php foreach ($timetable as $key => $v) {?>
                                <li><input type="checkbox" name="timetable_name" value="<?php echo $v['timetable_id']?>"  <?php if(in_array($v['timetable_id'], $hasTimetable)){?> checked="checked" <?php }?>   data-begin="<?php echo $v['begin_time']?>" data-end="<?php echo $v['end_time']?>" ><?php echo $v['begin_time'].'-'.$v['end_time']?></li>
                           
                            <?php }?>
                               
                            </ul>

                        </div>
                    </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" id="addSaveBtn">保存</button>
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>

<?php $this->load->view("public/footer"); ?>

<script type="text/javascript">
$(function () {

    $('#addSaveBtn').on('click', addSaveBtnEvt);
    $('.moneyInput').on('keyup', MoneyInputKeyupEvt);

    $("#site_id").on('change', changeClassroom);
   $("#classroom_id").on('change', changeTeacher);
   // $("#classroom_id").on('change', changeTimetable);
   // $("#timetable_id").on('change', changeTeacher);
   $("#teacher_id").on('change', changeTimetable);
   // $("#lesson_id").on('change', function(){
   //  $("#lesson_price").val($("#lesson_id option:selected").attr('data-lesson_price'));
   // });

    $('#course_date').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

})




function changeClassroom(){
    var site_id = $("#site_id").val();
    var classroom_id = $("#classroom_id").val();
    var timetable_id = $("#timetable_id").val();
    var teacher_id = $("#teacher_id").val();
    if (site_id=='') {showError('选择场地');return false;};
    $.ajax({
        url: '/course/getClassroom',
        type: 'POST',
        dataType: 'json',
        data:{site_id:site_id},
        success: function(data){
          /*  console.log( data );*/
            if (data.status == 1 ) {
                var str = '<option value="">选择教室</option>';
                 if(data.result.length>0){
                        
                    $.each(data.result, function(index, classroom) {
                         
                        str  +=  '<option value="'+classroom.classroom_id+'" data-classroom_people_num="'+classroom.classroom_people_num+'">'+classroom.classroom_name+'</option>';
                         
                    });
                    $("#classroom_id").html(str);
                   
                }  
            }else{
                
                showError( data.msg );
                return false;
            }
        }
    });
}
function changeTimetable(){
    var site_id = $("#site_id").val();
    var classroom_id = $("#classroom_id").val();
    var timetable_id = $("#timetable_id").val();
    var teacher_id = $("#teacher_id").val();
    if (classroom_id=='') {showError('选择教室');return false;};

    $("#classroom_people_num").val($("#classroom_id option:selected").attr('data-classroom_people_num'));
    $.ajax({
        url: '/course/getTimetable',
        type: 'POST',
        dataType: 'json',
        data:{site_id:site_id,classroom_id:classroom_id,timetable_id:timetable_id,teacher_id:teacher_id},
        success: function(data){
          /*  console.log( data );*/
            if (data.status == 1 ) {
                var tmpArr = [];
                 var str = '';
                 var content = '';
                 if(data.result.length>0){
                    str = '<div class="timetableli"><ul>';
                     $.each(data.result, function(index, val) {
                        
                        str  +=  '<li><input type="checkbox" name="timetable_name" value="'+val.timetable_id+'" data-begin="'+val.begin_time+'" data-end="'+val.end_time+'">'+val.begin_time+'-'+val.end_time+'</li>';
                      });
                    str  += '</ul></div>';
                       
                  $("#timetableList").html(str);
                }
            }else{
                
                showError( data.msg );
                return false;
            }
        }
    });
} 
function changeTeacher(){
     var site_id = $("#site_id").val();
    var classroom_id = $("#classroom_id").val();
    var timetable_id = $("#timetable_id").val();
    var teacher_id = $("#teacher_id").val();
    // if (timetable_id=='') {showError('选择时间区域');return false;};
    $("#teacher_id").html('');
    $.ajax({
        url: '/teacherCourse/getTeacher',
        type: 'POST',
        dataType: 'json',
        data:{site_id:site_id,classroom_id:classroom_id,timetable_id:timetable_id,teacher_id:teacher_id},
        success: function(data){
          /*  console.log( data );*/
            if (data.status == 1 ) {
                var str = '<option value="">选择老师</option>';
                 if(data.result.length>0){
                        
                    $.each(data.result, function(index, val) {
                         
                        str  +=  '<option value="'+val.teacher_id+'" >'+val.teacher_name+'</option>';
                         
                    });
                    $("#teacher_id").html(str);
              
                }  
                // changeLesson();
            }else{
                
                showError( data.msg );
                return false;
            }
        }
    });
} 
function changeLesson(){
     var site_id = $("#site_id").val();
    var classroom_id = $("#classroom_id").val();
    var timetable_id = $("#timetable_id").val();
    var teacher_id = $("#teacher_id").val();
    if (teacher_id=='') {showError('选择老师');return false;};
    $.ajax({
        url: '/course/getLesson',
        type: 'POST',
        dataType: 'json',
        data:{site_id:site_id,classroom_id:classroom_id,timetable_id:timetable_id,teacher_id:teacher_id},
        success: function(data){
          /*  console.log( data );*/
            if (data.status == 1 ) {
                 var str = '<option value="">选择课程</option>';
                 if(data.result.length>0){
                        
                    $.each(data.result, function(index, val) {
                         
                        str  +=  '<option value="'+val.lesson_id+'" data-lesson_price="'+val.lesson_price+'">'+val.lesson_name+'</option>';
                         
                    });
                    $("#lesson_id").html(str);
              
                }  
            }else{
                
                showError( data.msg );
                return false;
            }
        }
    });
} 

function MoneyInputKeyupEvt() {

    var regStrs = [
        ['^0(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
        ['[^\\d\\.]+$', ''], //禁止录入任何非数字和点
        ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
        ['^(\\d+\\.\\d{4}).+', '$1'] //禁止录入小数点后两位以上
    ];


    for (i = 0; i < regStrs.length; i++) {
        var reg = new RegExp(regStrs[i][0]);
        this.value = this.value.replace(reg, regStrs[i][1]);
    }


}
function addSaveBtnEvt(){
     var $this = $( this );
    var course_id = $("#course_id").val();
    var site_id = $("#site_id").val();
    var classroom_id = $("#classroom_id").val();
    var timetable_id = $("#timetable_id").val();
    var teacher_id = $("#teacher_id").val();
   
    var lesson_id = $("#lesson_id").val();
    var course_date = $("#course_date").val();
    // var lesson_price = $("#lesson_price").val();
    var classroom_people_num = $("#classroom_people_num").val();

    var timetable_name = $("input[name='timetable_name']:checked");

     if (course_date=='') {showError('选择日期');return false;};
   
    if (classroom_id=='') {showError('选择教室');return false;};
    if (teacher_id=='') {showError('选择老师');return false;};
    if (timetable_id=='') {showError('选择时间区域');return false;};
    
    if(timetable_name.length<1){
        showError("请选择场地");
        return false;
    }
    var timetable_arr = new Array(); 
    var timetable_begin = new Array(); 
    var timetable_end = new Array(); 
    $.each(timetable_name, function (i, obj) {
        timetable_arr[i] = $(obj).val();
        timetable_begin[i] = $(obj).attr('data-begin');
        timetable_end[i] = $(obj).attr('data-end');
    });
    // if (course_id=='') {showError('选择课程');return false;};
   
    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/teacherCourse/modifyAction',
            type:'POST',
            data:{course_id:course_id,
                site_id:site_id,
                classroom_id:classroom_id,
                // timetable_id:timetable_id,
                teacher_id:teacher_id,
                // lesson_id:lesson_id,
                course_date:course_date,
                // lesson_price:lesson_price,
                classroom_people_num:classroom_people_num,
                timetable_arr:timetable_arr,
                timetable_begin:timetable_begin,
                timetable_end:timetable_end
            },
        
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    <?php if($referUrl){?>
                    window.location = "<?php echo $referUrl?>";
                    <?php }else{?>
                          window.location = "/teacherCourse/index"
                    <?php }?>
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}

</script>

