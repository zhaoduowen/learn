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
    var lesson_id = $("#lesson_id").val();
    var lessonPic = $("input[name='lessonPic']");
    var lesson_name = $("#lesson_name").val();
    var lesson_time_length = $("#lesson_time_length").val();
    var lesson_price = $("#lesson_price").val();
    var lesson_strength = $("#lesson_strength").val();
    var lesson_type = $("input[name='lesson_type']:checked").val();
 
    if(lessonPic==undefined || lessonPic==''){
        showError("请上传课程图片");
        return false;
    }
    if(lesson_name == ''){
        showError("请输入课程名称");
        return false;
    }
    if(lesson_time_length == ''){
        showError("请输入时长");
        return false;
    }
    if(lesson_price == ''){
        showError("请输入课程价格");
        return false;
    }
    if(lesson_strength<1){
        showError("请定义课程强度");
        return false;
    }
    if(lessonPic.length<1){
        showError("请上传轮播图片");
        return false;
    }
    
    var content = ue.getContent();
    var lesson_remind = $("#lesson_remind").val();
    
    var picArr = new Array();
    $.each(lessonPic, function (i, obj) {
        picArr[i] = $(obj).val();
    });

    console.log(picArr);
    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/lesson/addAction',
            type:'POST',
            data:{
                lesson_id:lesson_id,
                lesson_name:lesson_name,
                lesson_time_length:lesson_time_length,
                lesson_price:lesson_price,
                lesson_type:lesson_type,
                lesson_strength:lesson_strength,
                lessonPic:picArr,
                lesson_content:content,
                lesson_remind:lesson_remind,
              
        },
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/lesson/index"
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}