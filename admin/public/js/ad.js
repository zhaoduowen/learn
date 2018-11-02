$(function () {

    $('#addSaveBtn').on('click', addSaveBtnEvt);
    // $('.moneyInput').on('keyup', MoneyInputKeyupEvt);

})

function addSaveBtnEvt(){
    var $this = $( this );
    var ad_id = $("#ad_id").val();
    var adPic = $("input[name='adPic']");
    var title = $("#title").val();
    var link_url = $("#link_url").val();
    var sortNum = $("#sortNum").val();
    var status = $("input[name='status']:checked").val();
 
    if(adPic==undefined || adPic==''){
        showError("请上传图片");
        return false;
    }
    if(title == ''){
        showError("请输入广告标题");
        return false;
    }
    if(link_url == ''){
        showError("请输入广告链接");
        return false;
    }
    
    if(adPic.length<1){
        showError("请上传图片");
        return false;
    }
    
    var ad_remark = $("#ad_remark").val();
    
    var picArr = new Array();
    $.each(adPic, function (i, obj) {
        picArr[i] = $(obj).val();
    });

    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/ad/addAction',
            type:'POST',
            data:{
                ad_id:ad_id,
                title:title,
                link_url:link_url,
                adPic:picArr,
                status:status,
                ad_remark:ad_remark,
                sort:sortNum,

        },
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/ad/index"
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}