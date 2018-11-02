$( function (){

    infomation_init();

})

function infomation_init (){

    infomation_bindEvt();

}
function infomation_bindEvt(){
    $( '#addInfomationBtn' ).on( 'click' , addInfomationBtnEvt  );
}
function addInfomationBtnEvt(){
    var $this = $( this );
    var title = $("#title").val();
    if(title == ''){
        showError("请输入标题");
        return false;
    }
    var web_infomation_type = $("#web_infomation_type").val();
    if(web_infomation_type == 0){
        showError("请选择类型");
        return false;
    }

    var outline = $("#outline").val();
    if (web_infomation_type==2 && outline=='') {
        showError("概要不能为空");
        return false;
    }
    var keywords = $("#keywords").val();
    var flag_out_site = $("input[name='flag_out_site']:checked" ).val();
    var out_site_url = $("#out_site_url").val();
    var infomationPic = $("input[name='infomationPic']").val();
    var content = ue.getContent();
    var status = $("input[name='status']:checked" ).val();
    var flag_recommend = $("input[name='flag_recommend']:checked" ).val();
    var web_infomation_id = $("#web_infomation_id").val();



    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/infomation/addAction',
            type:'POST',
            data:{
                web_infomation_id:web_infomation_id,
                title:title,
                web_infomation_type:web_infomation_type,
                outline:outline,
                keywords:keywords,
                flag_out_site:flag_out_site,
                out_site_url:out_site_url,
                infomationPic:infomationPic,
                content:content,
                status:status,
                flag_recommend:flag_recommend,
              
        },
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/infomation/listAction"
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}