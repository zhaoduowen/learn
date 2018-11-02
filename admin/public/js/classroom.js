$(function () {

    $('#addSaveBtn').on('click', addSaveBtnEvt);

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

function addTime(){
     
    var content = "";
   
    // content += "<div class='form-inline li'>";                                        
    // content += " <input type='text' name='begin_time' class='form-control' value='' /> - ";                                                                                   
    // content += " <input type='text' name='end_time' class='form-control' value=''  />";                                                                                   
    // content += "<a class='redbtn' href='javascript:;' onclick='$(this).parent().remove();'>删除</a>";                                          
    // content += "</div>"; 
    content = $("#timeSelect").html();                                      
    $("#timetableList").append(content);


}
function addSaveBtnEvt(){
    var $this = $( this );
    var id = $("#classroom_id").val();
    var site_id = $("#site_id").val();
    var classroom_name = $("#classroom_name").val();
    var classroom_people_num = $("#classroom_people_num").val();
    
    if(classroom_name == ''){
        showError("教室名称不能为空");
        return false;
    }
 
    if(classroom_people_num == ''){
        showError("场地人数不能为空");
        return false;
    }
    var timetableList = $("#timetableList .li");
    if(timetableList.length==0){
        showError('请时间区域');
        return false;
    }

    var ascData = new Array();

    $.each(timetableList, function (i, obj) {
        
        var btime = $(obj).find(".begin_time").val();
        var etime = $(obj).find(".end_time").val();
        
        ascData[i] = [btime,etime];
    });
   
    if(ascData.length == timetableList.length){
        $this.prop( 'disabled' , true );
        $.ajax({
            url: '/classroom/addAction',
                type:'POST',
                data:{
                    classroom_id:id,
                    site_id:site_id,
                    time_arr:ascData,
                    classroom_name:classroom_name,
                    classroom_people_num:classroom_people_num,
                  
            },
            dataType:'json',
            success:function(re){
                if(re.status == 1){
                    showSuccess('保存成功');
                    setTimeout(function () {
                        window.location = "/site/index"
                    }, 3000);
                }else{
                    showError(re.msg);
                    $this.prop( 'disabled' , false );
                }
            }
        })
    }
    
}








