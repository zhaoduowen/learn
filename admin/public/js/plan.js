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
    var plan_id = $("#plan_id").val();
    var plan_pic = $("input[name='plan_pic']").val();
    var planPic = $("input[name='planPic']");
    var plan_name = $("#plan_name").val();
    var plan_type = $("#plan_type").val();
    var plan_num_cg = $("#plan_num_cg").val();
    var plan_num_sj = $("#plan_num_sj").val();
    var plan_num_xz = $("#plan_num_xz").val();
    var plan_length = $("#plan_length").val();
    var plan_buy_num = $("#plan_buy_num").val();
    var plan_market_price = $("#plan_market_price").val();
    var plan_price = $("#plan_price").val();
    var plan_remind = $("#plan_remind").val();
    var x_coor = $("#lng").val();
    var y_coor = $("#lat").val();
    


    if(plan_pic==undefined || plan_pic==''){
        showError("请上传头图");
        return false;
    }
    if(planPic==undefined || planPic==''){
        showError("请上传课程图片");
        return false;
    }
    if(plan_name == ''){
        showError("请输入精练计划名称");
        return false;
    }
    if(plan_num_cg == ''){
        showError("请输入小班课次数");
        return false;
    }
     if(plan_num_sj == ''){
        showError("请输入私教课次数");
        return false;
    }
     if(plan_num_xz == ''){
        showError("请输入伙伴课次数");
        return false;
    }
    if(plan_length == ''){
        showError("请输入有效天数");
        return false;
    }
    if(plan_market_price == ''){
        showError("请输入市场价");
        return false;
    }
    if(plan_price == ''){
        showError("请输入销售价");
        return false;
    }
    if(plan_remind == ''){
        showError("请输入注意事项");
        return false;
    }

   
    if(planPic.length<1){
        // showError("请上传轮播图片");
        // return false;
    }
    
    var content = ue.getContent();
    
    var picArr = new Array();
    $.each(planPic, function (i, obj) {
        picArr[i] = $(obj).val();
    });

    console.log(picArr);
    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/plan/addAction',
            type:'POST',
            data:{
                plan_id:plan_id,
                plan_name:plan_name,
                plan_type:plan_type,
                plan_num_cg:plan_num_cg,
                plan_num_sj:plan_num_sj,
                plan_num_xz:plan_num_xz,
                plan_market_price:plan_market_price,
               
                plan_price:plan_price,
                plan_length:plan_length,
                plan_pic:plan_pic,
                planPic:picArr,
                plan_content:content,
                plan_remind:plan_remind,
                plan_buy_num:plan_buy_num,
                x_coor:x_coor,
                y_coor:y_coor
              
        },
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/plan/index"
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}