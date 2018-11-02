$(function () {

    product_init();

})

function product_init() {

    product_bindEvt();

}

function product_bindEvt() {


    $('#addProductBtn').on('click', addProductBtnEvt);
    $('#addFundProductBtn').on('click', addFundProductBtnEvt);
//	$( '#editProductBtn' ).on( 'click' , editProductBtnEvt  );

    $('.moneyInput').on('keyup', MoneyInputKeyupEvt);

    $("#product_class_id").on('change', changeProductClass)


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

function addProductBtnEvt() {
    var $this = $(this);
    var product_class_id = $("#product_class_id").val();
    if (product_class_id == '') {
        showError('请选择产品类型');
        return false;
    }
    var name = $.trim($('#name').val());
    var amount = parseFloat($('#amount').val());
    var limit_invest_amount = parseFloat($('#limit_invest_amount').val());
    var increase_amount = parseFloat($('#increase_amount').val());
    var limit_top_amount = parseFloat($('#limit_top_amount').val());

    var rate = parseFloat($('#rate').val());
    var fee_rate = parseFloat($('#fee_rate').val());

    var extra_rate = $('#extra_rate').val();
    var description = $.trim($('#description').val());
    var sale_begin_time = $.trim($('#sale_begin_time').val());
    var sale_end_time = $.trim($('#sale_end_time').val());
    var borrow_uid = $.trim($('#borrow_uid').val());
    var actual_borrower_uid = $.trim($('#actual_borrower_uid').val());
    var term_limit_type = $.trim($('#term_limit_type').val());
    var term_limit_length = $.trim($('#term_limit_length').val());
    var bill_number = $.trim($('#bill_number').val());
    var bill_end_time = $.trim($('#bill_end_time').val());
    var bank_name = $.trim($('#bank_name').val());
    var product_type = $("input[name='product_type']:checked").val();
    var flag_limit_time = $("input[name='flag_limit_time']:checked").val();
    var flag_hot_recommend = $("input[name='flag_hot_recommend']:checked").val();
    var device_limit = $("input[name='device_limit[]']:checked");
    var device_limit_length = $("input[name='device_limit[]']:checked").length;
    var product_class_type = $("#product_class_type").val();
    var term_top_length = $("#term_top_length").val();
    var loan_length = $("#loan_length").val();
    var punish_rate = $("#punish_rate").val();
  
    if (name == '') {
        showError('项目名称不能为空');
        return false;
    }
    if (product_class_type != 1 && product_class_id != 8&& product_class_id != 9) {
        if (bill_number == '') {
            showError('票据单号不能为空');
            return false;
        }
        if (bill_number.length > 30) {
            //      showError( '票据单号长度不能超过30' );
            //      return false;
        }
        if (bill_end_time == '') {
            showError('票据到期日不能为空');
            return false;
        }
        if (bank_name == '') {
            showError('承兑银行不能为空');
            return false;
        }
    }

    if (amount == '') {
        showError('项目金额不能为空');
        return false;
    }
    if (isNaN(amount)) {
        showError('项目金额必须是数字');
        return false;
    }
    if (amount < 0) {
        showError('项目金额不能小于0');
        return false;
    }
    if (rate == '') {
        showError('年化收益不能为空');
        return false;
    }
    if (isNaN(rate)) {
        showError('项年化收益必须是数字');
        return false;
    }
    if (rate < 0) {
        showError('项年化收益不能小于0');
        return false;
    }
    if (rate > 100) {
        showError('项年化收益不能大于100');
        return false;
    }
    if(product_class_id == 6 || product_class_id == 9) {
        if (borrow_uid == '') {
            showError('请选择名义借款人');
            return false;
        }
        if (fee_rate == '') {
            showError('请输入借款人利率');
            return false;
        }
        
        if (parseFloat(fee_rate) <= (parseFloat(rate) + parseFloat(extra_rate))) {
            showError('借款人利率应大于年化利率');
            return false;
        }
    } else {
        if (borrow_uid == '') {
            showError('请选择借款主体');
            return false;
        }
    }
    if (product_class_id == 6 || product_class_id == 7 || product_class_id == 9) {
        if (actual_borrower_uid == '') {
            showError('请选择实际借款人');
            return false;
        }
    }
    if (term_limit_length == '') {
        showError('项目期限不能为空');
        return false;
    }
    if (term_limit_length <= 0) {
        showError('项目期限不能小于等于0');
        return false;
    }
    if (isNaN(term_limit_length)) {
        showError('项目期限必须是数字');
        return false;
    }


    if (product_class_id == 9) {
        if (loan_length!='' && isNaN(loan_length)) {
            showError('借款期限必须是数字');
            return false;
        }
        if (punish_rate!='' && isNaN(punish_rate)) {
            showError('处罚利率必须是数字');
            return false;
        }
    }

    if (limit_invest_amount == '') {
        showError('起投金额不能为空');
        return false;
    }
    if (isNaN(limit_invest_amount)) {
        showError('起投金额必须是数字');
        return false;
    }
    if (limit_invest_amount < 0) {
        showError('起投金额不能小于0');
        return false;
    }

    if (parseInt(limit_invest_amount) != limit_invest_amount) {
        showError('起投金额必须是整数');
        return false;
    }
    if (limit_invest_amount > amount) {
        showError('起投金额不可大于项目金额');
        return false;
    }
    if (increase_amount == '') {
        showError('递增金额不能为空');
        return false;
    }
    if (isNaN(increase_amount)) {
        showError('递增金额必须是数字');
        return false;
    }
    if (increase_amount < 0) {
        showError('递增金额不能小于0');
        return false;
    }
    if (parseInt(increase_amount) != increase_amount) {
        showError('递增金额必须是整数');
        return false;
    }
    if (limit_invest_amount < increase_amount) {
        showError('起投金额不可小于递增金额');
        return false;
    }

    if (limit_invest_amount % increase_amount != 0) {
        showError('起投金额必须是递增金额的整数倍');
        return false;
    }
    if (extra_rate != '' && isNaN(extra_rate)) {
        showError('加息利率必须是数字');
        return false;
    }
    if (extra_rate < 0) {
        showError('加息利率不能小于0');
        return false;
    }
    if (extra_rate > 100) {
        showError('加息利率不能大于100');
        return false;
    }
//    if (isNaN(extra_rate)) {
//        showError( '加息利率必须是数字' );
//        return false;
//    } 
    if (sale_begin_time == '') {
        showError('销售开始日期不能为空');
        return false;
    }

    if (sale_end_time == '') {
        showError('销售结束日期不能为空');
        return false;
    }
    if (sale_begin_time > sale_end_time) {
        showError('销售开始日期不能大于结束日期');
        return false;
    }

    if (product_type == 1) {
        if (limit_top_amount == '' || isNaN(limit_top_amount) || limit_top_amount <= 0 || limit_top_amount > 1000000 || parseInt(limit_top_amount) != limit_top_amount) {
            showError('新手标投资限额必须为大于0小于等于1000000的整数');
            return false;
        }
    }


    if (device_limit_length < 1) {
        showError('请选择渠道限制');
        return false;
    }
    var device_limit_str = ",";
    var checkedPadOnly = false;
    device_limit.each(function () {
        device_limit_str += $(this).val() + ",";
        if ($(this).val() != 2) {
            checkedPadOnly = true;
        }
        ;
    });

    var productPic = $("input[name='productPic']");
    var productPicArr = new Array();
    $.each(productPic, function (i, obj) {
        productPicArr[i] = $(obj).val();
    });
    if (checkedPadOnly && product_class_type != 1&&product_class_id!=8) {
        if (productPicArr.length == 0) {
            showError('请上传产品图片');
            return false;
        }
    }
    var fee_rates = (fee_rate - rate - extra_rate);
    var fee = 0;
    if (fee_rates > 0) {
        fee = fee_rates;
    }
    if (product_class_id == 7 || product_class_id == 9) {
        if (term_top_length <= 0) {
        showError('最长投资期限必须大于0');
        return false;
    }
    }
    if (product_class_id == 7) {
        var brand = $("#brand").val();
        if (brand == "") {
            showError('请填写车辆品牌');
            return false;
        }
        var model = $("#model").val();
        if (model == "") {
            showError('请填写车辆型号');
            return false;
        }
        var price = $("#price").val();
        if (price == "") {
            showError('请填写车辆评估价');
            return false;
        }
        var cp1 = $("#cp1").val();
        if (cp1 == "") {
            showError('请填写车辆颜色');
            return false;
        }
        var vin_no = $("#vin_no").val();
        if (vin_no == "") {
            showError('请填写车架号');
            return false;
        }
        var engine_no = $("#engine_no").val();
        if (engine_no == "") {
            showError('请填写发动机号');
            return false;
        }
        var productPicCarLogo = $("input[name='productPicCarLogo']");
        var productPicCarLogoArr = new Array();
        $.each(productPicCarLogo, function (i, obj) {
            productPicCarLogoArr[i] = $(obj).val();
        });
        if (productPicCarLogoArr.length == 0) {
            showError('请上传车辆LOGO');
            return false;
        }


        var productPicCar = $("input[name='productPicCar']");
        var productPicCarArr = new Array();
        $.each(productPicCar, function (i, obj) {
            productPicCarArr[i] = $(obj).val();
        });
        if (productPicCarArr.length == 0) {
            showError('请上传车辆图片');
            return false;
        }
        var productPicCarAptitude = $("input[name='productPicCarAptitude']");
        var productPicCarAptitudeArr = new Array();
        $.each(productPicCarAptitude, function (i, obj) {
            productPicCarAptitudeArr[i] = $(obj).val();
        });
        if (productPicCarAptitudeArr.length == 0) {
            showError('请上传车辆资质图片');
            return false;
        }

        var productPicCarAptitude_text = $("input[name='productPicCarAptitude_text']");
        var productPicCarAptitudeArr_text = new Array();
        var flag = 0;
        $.each(productPicCarAptitude_text, function (i, obj) {
            productPicCarAptitudeArr_text[i] = $(obj).val();
            if ($(obj).val() == "") {
                showError('请填写车辆资质说明');
                flag = flag + 1;
            } else {
                var status = $(obj).val().substr(0, 1);//截取资质说明第一位，判断是否为数字
                if (isNaN(status)) {
                    showError('车辆资质说明请以‘1、XXX’规格填写');
                    flag = flag + 1;
                }
            }

        });
        if (flag != 0) {
            return false;
        }
        var car_id = $("#car_id").val();
    }

    if (product_class_id == 9) {
        var carNum = $(".carNum").length;
        if (carNum >= 10) {
            showError('最多10辆车');
            return false;
        }
        var carData = [];
        for (j = 0, ii = carNum; j < ii; j++) {
            var brand = $("#brand_"+j).val();
            if (brand == "") {
                showError('请填写车辆品牌');
                return false;
            }
            var model = $("#model_"+j).val();
            if (model == "") {
                showError('请填写车辆型号');
                return false;
            }
            var price = $("#price_"+j).val();
            if (price == "") {
                showError('请填写评估价');
                return false;
            }
            var cp1 = $("#cp1_"+j).val();
            if (cp1 == "") {
                showError('请填写车辆颜色');
                return false;
            }
            var vin_no = $("#vin_no_"+j).val();
            if (vin_no == "") {
                showError('请填写车架号');
                return false;
            }
            var engine_no = $("#engine_no_"+j).val();
            if (engine_no == "") {
                showError('请填写发动机号');
                return false;
            }

            var nowCar = $("#carNum_"+j);
            var productPicCar = nowCar.find("input[name='productPicCar']");
            var productPicCarArr = new Array();
            $.each(productPicCar, function (i, obj) {
                productPicCarArr[i] = $(obj).val();
            });

            if (productPicCarArr.length == 0) {
                showError('请上传车辆图片');
                return false;
            }
            var productPicCarAptitude = nowCar.find("input[name='productPicCarAptitude']");
            var productPicCarAptitudeArr = new Array();
            $.each(productPicCarAptitude, function (i, obj) {
                productPicCarAptitudeArr[i] = $(obj).val();
            });
            if (productPicCarAptitudeArr.length == 0) {
                showError('请上传车辆资质图片');
                return false;
            }

            var productPicCarAptitude_text = nowCar.find("input[name='productPicCarAptitude_text']");
            var productPicCarAptitudeArr_text = new Array();
            var flag = 0;
            $.each(productPicCarAptitude_text, function (i, obj) {
                productPicCarAptitudeArr_text[i] = $(obj).val();
                if ($(obj).val() == "") {
                    showError('请填写车辆资质说明');
                    flag = flag + 1;
                } else {
                    var status = $(obj).val().substr(0, 1);//截取资质说明第一位，判断是否为数字
                    if (isNaN(status)) {
                        showError('车辆资质说明请以‘1、XXX’规格填写');
                        flag = flag + 1;
                    }
                }

            });
            carData[j] = [brand,model,price,cp1,vin_no,engine_no,productPicCarArr,productPicCarAptitudeArr,productPicCarAptitudeArr_text];
            //console.log(carData);
           
        }
        
        if (flag != 0) {
            return false;
        }
        var car_id = $("#car_id").val();
    }


//    console.log(productPicArr.toString());return false;
    var product_id = $("#product_id").val();
    $this.prop('disabled', true);
    $.ajax({
        url: '/product/actionSave',
        type: 'POST',
        data: {
            product_class_id: product_class_id,
            product_id: product_id,
            name: name,
            amount: amount,
            limit_invest_amount: limit_invest_amount,
            increase_amount: increase_amount,
            limit_top_amount: limit_top_amount,
            rate: rate,
            fee_rate: fee,
            flag_limit_time: flag_limit_time,
            flag_hot_recommend: flag_hot_recommend,
            extra_rate: extra_rate,
            description: description,
            sale_begin_time: sale_begin_time,
            sale_end_time: sale_end_time,
            borrower_uid: borrow_uid,
            actual_borrower_uid: actual_borrower_uid,
            term_limit_type: term_limit_type,
            term_limit_length: term_limit_length,
            term_top_length: term_top_length,
            bill_number: bill_number,
            bill_end_time: bill_end_time,
            bank_name: bank_name,
            product_type: product_type,
            device_limit: device_limit_str,
            productPic: productPicArr,
            brand: brand,
            model: model,
            price: price,
            cp1: cp1,
            vin_no: vin_no,
            engine_no: engine_no,
            productPicCarArr: productPicCarArr,
            productPicCarAptitudeArr: productPicCarAptitudeArr,
            productPicCarAptitudeArr_text: productPicCarAptitudeArr_text,
            car_id: car_id,
            productPicCarLogo: productPicCarLogoArr,
            carData:carData,
            punish_rate:punish_rate,
            loan_length:loan_length
        },
        dataType: 'json'
    }).done(function (data) {
        if (data.status == 1) {
            $.scojs_message('保存成功', $.scojs_message.TYPE_OK);
            window.location = '/product/index';
        } else {
            showError(data.msg);
            $this.prop('disabled', false);
        }
        //console.log( data );
    }).fail(function () {

        $this.prop('disabled', false);
    })

}


//基金产品挺安静
function addFundProductBtnEvt() {
    var $this = $(this);
    var name = $.trim($('#name').val());

    var rate = parseFloat($('#rate').val());
    var length = $.trim($('#length').val());

    var company_id_2 = $.trim($('#company_id_2').val());
    var company_id_1 = $.trim($('#company_id_1').val());
    var comment = $.trim($('#comment').val());

    var status = $("input[name='status']:checked").val();

    if (name == '') {
        showError('产品名称不能为空');
        return false;
    }

    if (rate == '') {
        showError('预期收益率不能为空');
        return false;
    }
    if (isNaN(rate)) {
        showError('预期收益率必须是数字');
        return false;
    }

    if (length == '') {
        showError('投资期限不能为空');
        return false;
    }
    if (company_id_2 == '') {
        showError('江浦公司起投金额不能为空');
        return false;
    }
    if (isNaN(company_id_2)) {
        showError('江浦公司起投金额必须是数字');
        return false;
    }

    if (company_id_1 == '') {
        showError('江南京公司起投金额不能为空');
        return false;
    }
    if (isNaN(company_id_1)) {
        showError('南京公司起投金额必须是数字');
        return false;
    }

    var product_id = $("#product_id").val();
    $this.prop('disabled', true);
    $.ajax({
        url: '/product/fundActionSave',
        type: 'POST',
        data: {
            product_id: product_id,
            name: name,
            rate: rate,
            length: length,
            company_id_1: company_id_1,
            company_id_2: company_id_2,
            comment: comment,
            status: status,

        },
        dataType: 'json'
    }).done(function (data) {
        if (data.status == 1) {
            showError('保存成功');
            window.location = '/product/fundindex';
        } else {
            showError(data.msg);
            $this.prop('disabled', false);
        }
        //console.log( data );
    }).fail(function () {

        $this.prop('disabled', false);
    })

}

//选择产品类型
function changeProductClass() {
    var product_class_id = $("#product_class_id").val();
    if (product_class_id == '') {
        return false;
    }
    $.ajax({
        type: 'post',
        url: "/product_category/getClassinfo",
        data: {'product_class_id': product_class_id},
        dataType: 'json',
        success: function (rs) {
            if (rs.status == 1) {
                data = rs.data;
                $("#div").hide();
                $("#limit_invest_amount").val(data.limit_invest_amount);
                $("#increase_amount").val(data.increase_amount);
                if (data.term_limit_type == 1) {
                    var text = '个月';
                } else {
                    var text = '天';
                }
                $("#term_limit_type").val(data.term_limit_type);
                $("#term_limit_Text").text(text);
                $("#term_top_Text").text(text);
                $("#termTopLength").hide();
                 $(".ruixianghui").hide();
                //股权收益
                if (data.product_class_type == 1) {
                    $('#uploadPic_success').parent().parent().hide();
                    $('#bill_number').parent().parent().hide();
                    $('#bill_end_time').parent().parent().hide();
                    $('#bank_name').parent().parent().hide();
                    $("#product_class_type").val(1);
                } else {
                    $('#uploadPic_success').parent().parent().show();
                    $('#bill_number').parent().parent().show();
                    $('#bill_end_time').parent().parent().show();
                    $('#bank_name').parent().parent().show();
                    $("#product_class_type").val(0);
                }
                //个人抵押
                if ( data.product_class_id == 6) {
                    $("#actualLoad").show();
                    $("#fee_rates").show();
                    $("#fee_pre_rate").show();
                    $('#uploadPic_success').parent().parent().hide();
                    $('#bill_number').parent().parent().hide();
                    $('#bill_end_time').parent().parent().hide();
                    $('#bank_name').parent().parent().hide();
                    $("#product_class_type").val(1);
                    $("#load").html("名义借款人");
                    $('#borrow_uid').empty();
                    $("#borrow_uid").append("<option value=''>请选择借款人</option>");
                    for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                        if (borrowinfo[i].borrower_type == "0") {
                            $("#borrow_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                        }
                    }
                    $('#actual_borrower_uid').empty();
                    $("#actual_borrower_uid").append("<option value=''>请选择借款人</option>");
                    for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                        if (borrowinfo[i].borrower_type == "0") {
                            $("#actual_borrower_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                        }
                    }
                } else {
                    $("#load").html("借款主体");
                    $("#actualLoad").hide();
                    $('#uploadPic_success').parent().parent().show();
                    $('#bill_number').parent().parent().show();
                    $('#bill_end_time').parent().parent().show();
                    $('#bank_name').parent().parent().show();
                    $("#product_class_type").val(0);
                    $('#borrow_uid').empty();
                    $("#borrow_uid").append("<option value=''>请选择借款人</option>");
                    for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                        if (borrowinfo[i].borrower_type == "1") {
                            $("#borrow_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                        }
                    }

                    $("#fee_rates").hide();
                    $("#fee_pre_rate").hide();
                }
                   //快车贷部分
                // if (data.product_class_id == 7) {
                    // $("#fee_rates").show();
                    // $("#fee_pre_rate").show();

                    // $('#bill_number').parent().parent().hide();
                    // $('#bill_end_time').parent().parent().hide();
                    // $('#bank_name').parent().parent().hide();
                    // $('#uploadPic_success').parent().parent().hide();
                    // $("#product_class_type").val(1);
                    
                    // $('#borrow_uid').empty();
                    // $("#borrow_uid").append("<option value=''>请选择借款人</option>");
                    // for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                    //     if (borrowinfo[i].borrower_type == "0") {
                    //         $("#borrow_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                    //     }
                    // }

                    // $("#actualLoad").show();
                    // $("#load").html("名义借款人");
                    
                    // $('#actual_borrower_uid').empty();
                    // $("#actual_borrower_uid").append("<option value=''>请选择借款人</option>");
                    // for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                    //     if (borrowinfo[i].borrower_type == "1") {
                    //         $("#actual_borrower_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                    //     }
                    // }


                // } 
		
                if (data.product_class_id == 8) {
                    $("#fee_rates").show();
                    $("#fee_pre_rate").show();

                    $('#bill_number').parent().parent().hide();
                    $('#bill_end_time').parent().parent().hide();
                    $('#bank_name').parent().parent().hide();
                    $('#uploadPic_success').parent().parent().hide();
                    $("#product_class_type").val(1);
		    $("#load").html("借款主体");
		    $('#borrow_uid').empty();
                    $("#borrow_uid").append("<option value=''>请选择借款人</option>");
                    for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                          $("#borrow_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                    }

                } 


                //车融贷
                if (product_class_id == 9 || data.product_class_id == 7) {
                    $("#actualLoad").show();
                    $("#termTopLength").show();
                    $("#fee_rates").show();
                    $("#fee_pre_rate").show();
                    $('#uploadPic_success').parent().parent().hide();
                    $('#bill_number').parent().parent().hide();
                    $('#bill_end_time').parent().parent().hide();
                    $('#bank_name').parent().parent().hide();
                    $("#product_class_type").val(1);
                    $("#load").html("名义借款人");
                    $('#borrow_uid').empty();
                    $("#borrow_uid").append("<option value=''>请选择借款人</option>");
                    for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                        // if (borrowinfo[i].borrower_type == "1") {
                        //     $("#borrow_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                        // }

                        $("#borrow_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                       
                    }
                    $('#actual_borrower_uid').empty();
                    $("#actual_borrower_uid").append("<option value=''>请选择借款人</option>");
                    for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                        // if (borrowinfo[i].borrower_type == "1") {
                        //     $("#actual_borrower_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                        // }

                        $("#actual_borrower_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                        
                    }
                } 




                  if (data.product_class_id == 11) {
                    // $("#fee_rates").show();
                    // $("#fee_pre_rate").show();
                    $("#termTopLength").show();
                    $('#bill_number').parent().parent().hide();
                    $('#bill_end_time').parent().parent().hide();
                    $('#bank_name').parent().parent().hide();
                    // $('#uploadPic_success').parent().parent().hide();
                    $("#product_class_type").val(1);
                    $("#load").html("借款主体");
                    $('#borrow_uid').empty();
                    $("#borrow_uid").append("<option value=''>请选择借款人</option>");
                    for (i = 0, ii = borrowinfo.length; i < ii; i++) {
                          if (borrowinfo[i].borrower_type == "1") {
                            $("#borrow_uid").append("<option value='" + borrowinfo[i].borrower_uid + "'>" + borrowinfo[i].enterprise_name + "</option>");
                        }
                    }

                } 



                 if (data.product_class_id == 9) {

                    $(".ruixianghui").show();
                   

                } 



            } else {
                alert(rs['msg']);
            }
        }
    });

}


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
    $('#saleStartDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
    $('#saleEndDate').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
    $('#sale_begin_time').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd hh:ii:ss',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 0

    });
    $('#sale_end_time').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd hh:ii:ss',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 0

    });
    $('#payment_end_time').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });
    $('#bill_end_time').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        minView: 2

    });

})




