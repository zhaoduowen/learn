$(function () {

    $('#addSaveBtn').on('click', addSaveBtnEvt);
    $('.moneyInput').on('keyup', MoneyInputKeyupEvt);

})

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
    var teacher_id = $("#teacher_id").val();
    var teacherPic = $("input[name='teacherPic']").val();
    var teacher_name = $("#teacher_name").val();
    var teacher_sign = $("#teacher_sign").val();
    var teacher_mobile = $("#teacher_mobile").val();
    var change_site_name = $("input[name='change_site_name[]']:checked");
    var lesson_arr = $("input[name='lesson_arr[]']:checked");

    if(teacherPic==undefined || teacherPic==''){
        showError("请老师头像");
        return false;
    }
    if(teacher_name == ''){
        showError("请输入老师名称");
        return false;
    }
    if(change_site_name.length<1){
        showError("请选择场地");
        return false;
    }
    var change_site_arr = new Array(); 
    $.each(change_site_name, function (i, obj) {
        change_site_arr[i] = $(obj).val();
    });
    
    if(teacher_sign == ''){
        showError("请输入老师简介");
        return false;
    }
    if(teacher_mobile == ''){
        showError("请输入老师电话");
        return false;
    }

    if(lesson_arr.length<1){
        showError("请选择课程");
        return false;
    }
    
    var content = ue.getContent();
    var teacher_remark = $("#teacher_remark").val();
    

    var lessonArr = new Array(); 
    $.each(lesson_arr, function (i, obj) {
        lessonArr[i] = $(obj).val();
    });

    
    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/teacher/addAction',
            type:'POST',
            data:{
                teacher_id:teacher_id,
                teacher_name:teacher_name,
                sign:teacher_sign,
                mobile:teacher_mobile,
                change_site_arr:change_site_arr,
                lesson_arr:lessonArr,
                teacher_avatar:teacherPic,
                content:content,
                remark:teacher_remark,
              
        },
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/teacher/index"
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}
