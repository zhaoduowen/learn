$(function () {

    $('#addSaveBtn').on('click', addSaveBtnEvt);
    // $('.moneyInput').on('keyup', MoneyInputKeyupEvt);

})

function addSaveBtnEvt(){
    var $this = $( this );
    var set_id = $("#set_id").val();
    var img_url = $("input[name='formPic']").val();
    var title = $("#title").val();
    var link_url = $("#link_url").val();
    var sortNum = $("#sortNum").val();
    var status = $("input[name='status']:checked").val();
 
    if(adPic==undefined || adPic==''){
        showError("请上传图片");
        return false;
    }
    if(title == ''){
        showError("请输入标题");
        return false;
    }
    if(link_url == ''){
        showError("请输入链接");
        return false;
    }
    
    if(img_url== ''){
        showError("请上传图片");
        return false;
    }
    

    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/ad/addAction',
            type:'POST',
            data:{
                set_id:set_id,
                title:title,
                link_url:link_url,
                img_url:img_url,
                status:status,
                ordern:sortNum,

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