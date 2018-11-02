//新增
$("#send").click(function(event) {
    var content = ue.getContent();
    var title = $("#title").val();
    if (title.length == 0) {
        showError('标题不能为空');
        return false;
    }else if (content.length == 0){
        showError('正文不能为空');
        return false;
    }
    $.ajax({
        url: '/webMail/send',
        type: 'POST',
        dataType: 'json',
        data: {'title': title, 'content': content},
        success:function(data){
            if (data.status <= 0) {
                showError(data.msg);
                return false;
            }else {
                showSuccess(data.msg);
                // window.location = window.location;
            }
        },
        error:function(data) {
            showError('网络错误，请联系管理员');
        }
    })
});

//修改
$("#save").click(function(event) {
    var content = ue.getContent();
    var title = $("#title").val();
    if (title.length == 0) {
        showError('标题不能为空');
        return false;
    }else if (content.length == 0){
        showError('正文不能为空');
        return false;
    }
    $.ajax({
        url: '/webMail/save',
        type: 'POST',
        dataType: 'json',
        data: {'title': title, 'content': content, 'webMailId': webMailId},
        success:function(data){
            if (data.status <= 0) {
                showError(data.msg);
                return false;
            }else {
                showSuccess(data.msg);
                // window.location = window.location;
            }
        },
        error:function(data) {
            showError('网络错误，请联系管理员');
        }
    })
});


//删除
$("#delete").click(function(event) {
    $.ajax({
        url: '/webMail/delete',
        type: 'POST',
        dataType: 'json',
        data: {'webMailId': webMailId},
        success:function(data){
            if (data.status <= 0) {
                showError(data.msg);
                return false;
            }else {
                showSuccess(data.msg);
                return false;
            }
        },
        error:function(data) {
            showError('网络错误，请联系管理员');
        }
    })
});