$(function () {

    $('#addSaveBtn').on('click', addSaveBtnEvt);
    $('.moneyInput').on('keyup', MoneyInputKeyupEvt);

    $("#site_id").on('change', changeClassroom);
   $("#classroom_id").on('change', changeTimetable);
   $("#timetable_id").on('change', changeTeacher);
   $("#teacher_id").on('change', changeLesson);
   $("#lesson_id").on('change', function(){
    $("#lesson_price").val($("#lesson_id option:selected").attr('data-lesson_price'));
   });

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
                $("#classroom_id").html('');
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
                 var str = '<option value="">选择时间区域</option>';
                 if(data.result.length>0){
                        
                    $.each(data.result, function(index, val) {
                         
                        str  +=  '<option value="'+val.timetable_id+'" >'+val.begin_time+'--'+val.end_time+'</option>';
                         
                    });
                    $("#timetable_id").html(str);
              
                }  
                // changeTeacher();
            }else{
                
                showError( data.msg );
                 $("#timetable_id").html('');
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
    if (timetable_id=='') {showError('选择时间区域');return false;};
    $.ajax({
        url: '/course/getTeacher',
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
                 $("#teacher_id").html('');
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
                 $("#lesson_id").html('');
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
    var lesson_price = $("#lesson_price").val();
    var classroom_people_num = $("#classroom_people_num").val();
     if (course_date=='') {showError('选择日期');return false;};
   
    if (classroom_id=='') {showError('选择教室');return false;};
    if (timetable_id=='') {showError('选择时间区域');return false;};
    if (teacher_id=='') {showError('选择老师');return false;};
    if (course_id=='') {showError('选择课程');return false;};
   
    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/course/addAction',
            type:'POST',
            data:{course_id:course_id,
                site_id:site_id,
                classroom_id:classroom_id,
                timetable_id:timetable_id,
                teacher_id:teacher_id,
                lesson_id:lesson_id,
                course_date:course_date,
                lesson_price:lesson_price,
                classroom_people_num:classroom_people_num,
            },
        
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    if(course_id){
                        window.location = referURL
                    }else{
                         window.location = "/course/index"
                    }
                }, 3000);
            }else{
                showError(re.msg);
                $this.prop( 'disabled' , false );
            }
        }
    })
}