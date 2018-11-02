<?php $this->load->view('public/header'); ?>
 <style type="text/css">
.timetableli{    
    padding-bottom: 20px;
    margin: 10px;
    float: left;
    width: 900px;
    border-bottom: 1px solid;
}
    .timetableli .siname{font-size:17px;padding-right:200px;}
    .timetableli div{padding-left: 10px;width: 210px;display:block;float:left;    border: 1px black solid;    margin-left: 10px;}
    .timetableli ul{list-style:none;width: 200px;}
</style>

    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">自选排课 </a></li>
                <li class="active">添加排课</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="" id="plan_id">
                <div class="form-group">
                        <label for="inputPush2" class="col-sm-2 control-label"><span class="text-red">*</span>日期</label>
                        
                        <div class="col-sm-9">
                        
                                <?php foreach ($weekDay as $key => $value) {?>
                                 
                                    <label class="checkbox-inline">
                                        <input name="course_date[]" class="checkbox " type="checkbox" value="<?php echo $value['d'] ?>" name="lesson_type_limit[]"><?=$value['date']?><?php echo '('.$value['week'].')'?>
                                    </label>
                                  

                                  <?php }?>
                                  
                               
                          
                        </div>
                    </div>
                 <div class="db"></div>

                   <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>老师</label>
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
                                   

                            </div>
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


    <!-- <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/teacher_course.js"></script> -->
<?php $this->load->view("public/footer"); ?>
<script type="text/javascript">
$(function () {

    $('#addSaveBtn').on('click', addSaveBtnEvt);
    $('.moneyInput').on('keyup', MoneyInputKeyupEvt);

   $("#teacher_id").on('change', changeTimetable);

    $('#course_date').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
     $('#course_date_end').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

})




function changeTimetable(){
    var teacher_id = $("#teacher_id").val();
    $.ajax({
                    url: '/teacherCourse/getSite',
                    type: 'POST',
                    dataType: 'json',
                    data:{teacher_id:teacher_id},
                    beforeSend:function(){//请求之前执行函数
                        $("body").append('<div class="pload">正在加载...</div>');
                      },
                     complete: function() {//请求之后执行函数
                        $(".pload").remove();
                     },
                    success: function(data){
                      /*  console.log( data );*/
                        if (data.status == 1 ) {
                         var tmpArr = [];
                         var str = '';
                         var content = '';
                          $.each(data.result, function(index, val) {
                                str = '<div class="timetableli">';
                                str +='<p><span class="siname">'+val.site_name+'</span><input class="checkAll" type="checkbox" value="1" checked>全选 &nbsp;&nbsp;&nbsp;<span onclick="$(this).parent().parent().remove()">删除</span></p>';
                                if(val.classroom.length>0){
                                $.each(val.classroom, function(ic, iv) {    
                                    str +='<div class="classroom_select" data-classroom_id="'+iv.classroom_id+'"><h5>'+iv.classroom_name+'</h5>'
                                        +'<ul>';
                                    $.each(iv.timetable, function(ti, tv) {
                                        str  +=  '<li><input type="checkbox" name="timetable_name" value="'+tv.timetable_id+'" checked>'+tv.begin_time+'-'+tv.end_time+'</li>';
                                    });

                                    str  += '</ul></div>';
                                 });
                                }
                                
                                str  += '</div>';
                                content += str;

                          });
                          $("#timetableList").html(content);
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

$("#timetableList").on('click',".checkAll",function(){
                $(this).parent().parent().find('input[name="timetable_name"]').prop("checked", this.checked);
            });

function addSaveBtnEvt(){
     var $this = $( this );
    var course_id = $("#course_id").val();
    var teacher_id = $("#teacher_id").val();
    // var course_date = $("#course_date").val();
    // var course_date_end = $("#course_date_end").val();
     
    var course_date = $("input[name='course_date[]']:checked");
    var timetable_name = $("input[name='timetable_name']:checked");

     if (course_date.length < 1) {showError('选择日期');return false;};
     // if (course_date_end!='' && course_date>=course_date_end) {showError('结束日期不能小于开始日期');return false;};
   

    var dateArr = new Array(); 
    $.each(course_date, function (i, obj) {
        dateArr[i] = $(obj).val();
    });

    if (teacher_id=='') {showError('选择老师');return false;};
    var classroom_arr = new Array();
    var error = 0;
    var classroom_select = $(".classroom_select");
    $.each(classroom_select, function (i, obj) {
        var timetable_name=$(obj).find("input[name='timetable_name']:checked");
         if(timetable_name.length>=1){
            var time_arr = new Array();
            
            var classroomid = $(obj).attr('data-classroom_id');
            $.each(timetable_name, function (j, jobj) {
               
                time_arr[j] = $(jobj).val();
            });
            classroom_arr[i] = [classroomid,time_arr];
         }else{
            showError('有教室未勾选的时间');
            error = 1;
            return false;
         }
     })
    if (error==1) {return false};
    if(classroom_arr.length<1){
        showError("请选择时间段");
        return false;
    }


   
    $this.prop( 'disabled' , true ).text('提交中');
    $.ajax({
        url: '/teacherCourse/addAction',
            type:'POST',
            data:{course_id:course_id,
                teacher_id:teacher_id,
                course_date:dateArr,
                // course_date_end:course_date_end,
                classroom_arr:classroom_arr,
            },
        
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/teacherCourse/index"
                }, 3000);
            }else{
                showError(re.msg);
                $this.prop( 'disabled' , false ).text('保存');
            }
        }
    })
}

</script>
