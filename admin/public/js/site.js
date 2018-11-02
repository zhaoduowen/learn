$( function (){

    site_init();

})

function site_init (){

    site_bindEvt();

}
function site_bindEvt(){
    $( '#addSiteBtn' ).on( 'click' , addSiteBtnEvt  );
}
function addSiteBtnEvt(){
    var $this = $( this );
    var site_id = $("#site_id").val();
    var lng = $("#lng").val();
    var lat = $("#lat").val();
    var sitePic = $("input[name='sitePic']").val();
    var site_name = $("#site_name").val();
    var site_address = $("#site_address").val();
    var site_mobile = $("#site_mobile").val();
    var lesson_type_limit = $("input[name='lesson_type_limit[]']:checked");
    var lesson_arr = $("input[name='lesson_arr[]']:checked");
 
    if(sitePic==undefined || sitePic==''){
        showError("请上传场地图片");
        return false;
    }
    if(site_name == ''){
        showError("请输入场地名称");
        return false;
    }
    if(site_address == ''){
        showError("请输入场地地址");
        return false;
    }
    if(site_mobile == ''){
        showError("请输入联系电话");
        return false;
    }
    if(lesson_type_limit.length<1){
        showError("请选择课程类型");
        return false;
    }
    if(lesson_arr.length<1){
        showError("请选择课程");
        return false;
    }
    
    var content = ue.getContent();
    var site_remark = $("#site_remark").val();
    
    var device_limit_str = ",";
    lesson_type_limit.each(function () {
        device_limit_str += $(this).val() + ",";
    });
    var lessonArr = new Array(); 
    $.each(lesson_arr, function (i, obj) {
        lessonArr[i] = $(obj).val();
    });

    
    $this.prop( 'disabled' , true );
    $.ajax({
        url: '/site/addAction',
            type:'POST',
            data:{
                site_id:site_id,
                site_name:site_name,
                site_address:site_address,
                site_mobile:site_mobile,
                lesson_type_limit:device_limit_str,
                lesson_arr:lessonArr,
                sitePic:sitePic,
                site_content:content,
                site_remark:site_remark,
                x_coor:lng,
                y_coor:lat,
              
        },
        dataType:'json',
        success:function(re){
            if(re.status == 1){
                $.scojs_message(re.msg, $.scojs_message.TYPE_OK);
                setTimeout(function () {
                    window.location = "/site/index"
                }, 3000);
            }else{
                showError(re.msg);
            }
        }
    })
}