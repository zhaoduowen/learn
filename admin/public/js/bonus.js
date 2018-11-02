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
    var bonus_id = $("#bonus_id").val();
    var bonus_name = $("#bonus_name").val();
    var amount = $("#amount").val();
    var term_days = $("#term_days").val();
    var bonus_type = $("input[name='bonus_type']:checked").val();
    var category = $("input[name='category']:checked").val();
    var status = $("input[name='status']:checked").val();
    var description = $("#description").val();
    
   
    if(bonus_name == ''){
        showError("请输入优惠券标题");
        return false;
    }
   
    if(amount == ''){
        showError("请输入金额");
        return false;
    }
    if(term_days == ''){
        showError("请输入有效期");
        return false;
    }
    if(bonus_type == ''){
        showError("请选择类型");
        return false;
    }
    if(category == ''){
        showError("请输入发放方式");
        return false;
    }
    if(description == ''){
        showError("请输入生成原因");
        return false;
    }
    

    
    // $this.prop( 'disabled' , true );
    $.ajax({
        url: '/bonus/addAction',
            type:'POST',
            data:{
                bonus_id:bonus_id,
                bonus_name:bonus_name,
                bonus_type:bonus_type,
                category:category,
                description:description,
                status:status,
                amount:amount,
                term_days:term_days,
              
        },
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/bonus/index"
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}
