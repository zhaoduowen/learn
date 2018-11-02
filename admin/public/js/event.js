$(function () {

    webset_init();

})

function webset_init() {

    webset_bindEvt();

}

function webset_bindEvt() {


    $('#eventHandleBtn').on('click', eventHandleBtnEvt);
   



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


function eventHandleBtnEvt(){
    var $this = $( this );
    var id = $("#id").val();
    var award_time = $("#award_time").val();
    var event_type = $("#event_type").val();
    if(award_time == ''){
        showError("开奖日期不能为空");
        return false;
    }
 
    if(event_type == ''){
        showError("活动类型不能为空");
        return false;
    }
    var status = $("input[name='status']:checked" ).val();
    var award_user_list = $("#award_user_list .li");
    if(award_user_list.length==0){
        showError('请添加中奖名单');
        return false;
    }

    var ascData = new Array();

    $.each(award_user_list, function (i, obj) {
        var mobile = $(obj).find("select[name='award_user']").val();
        // var uid = $(obj).find("input[name='event_award_desc']").val();
        var event_award_desc = $(obj).find("input[name='event_award_desc']").val();
        
       
        if (mobile=="") {
            showError('中奖名单不能为空');
           
            return false;
        }
        
        ascData[i] = [mobile,event_award_desc];
    });
   
    if(ascData.length == award_user_list.length){
        $this.prop( 'disabled' , true );
        $.ajax({
            url: '/event/handle',
                type:'POST',
                data:{
                    id:id,
                    award_time:award_time,
                    event_type:event_type,
                    award_list:ascData,
                    status:status
            },
            dataType:'json',
            success:function(re){
                if(re.status == 1){
                    showSuccess('保存成功');
                    setTimeout(function () {
                        window.location = "/event/index"
                    }, 3000);
                }else{
                    showError(re.msg);
                }
            }
        })
    }
    
}


//点击增加按钮
// $('.add').click(function() {
//     var content = "";
   
//     content += "<div class='form-inline li'>";                                          
//     content += '<label class="branch" style="text-align:left;">';                                          
//     content += '<select style="display:none;" class="chosen-select" tabindex="2" name="award_user" ></select>';                                          
//     content += '</label>';                                          
//     content += " <input type='text' name='event_award_desc' class='form-control'value=''/>";                                          
//     content += "<a class='redbtn add' href='javascript:;'>+</a>";                                          
//     content += "<a class='redbtn' href='javascript:;' onclick='$(this).parent().remove();'>-</a>";                                          
//     content += "</div>";                                          
   
//     $(this).parent().after(content);

   
// })
$("body").on("click", ".add", function() {
var content = "";
   
    content += "<div class='form-inline li'>";                                          
    content += '<label class="branch" style="text-align:left;">';                                          
    content += '<select style="display:none;" class="chosen-select" tabindex="2" name="award_user" placeholder="输入手机号码" ></select>';                                          
    content += '</label>';                                          
    content += " <input type='text' name='event_award_desc' class='form-control'value='' placeholder='奖品内容'/>";                                          
    content += "<a class='redbtn add' href='javascript:;'>+</a>";                                          
    content += "<a class='redbtn' href='javascript:;' onclick='$(this).parent().remove();'>-</a>";                                          
    content += "</div>";                                          
   
    $(this).parent().after(content);
    $(this).parent().next().find('.chosen-select').click();
})


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
    $('#award_time').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
    $('#updatebegintime').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

})




