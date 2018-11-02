/*
* @Author: h_yajie
* @Date:   2016-11-08 11:19:39
* @Last Modified by:   h_yajie
* @Last Modified time: 2016-11-28 10:23:31
*/

'use strict';

!function ( window , $) {

    var SendCode = function ( obj, opt ){

        var _this = this;

        this.$obj = $( obj );
        this.interval = 60;
        this.timmer = null;
        var defaultOpt = {
            type:'get',
            url:'',
            data:{},
            mobile:'',
            error:'',
            text:'重发X秒',
            fn:null
        }
        this.opts = $.extend( true, defaultOpt, opt );

        this.init();
    };

    SendCode.prototype = {

        constructor:SendCode,

        init:function (){
            var This = this,
                mobile = this.opts.mobile; 
            if ( mobile == '' ) {
                showError('手机号不能为空');
                return false;
            }
           	if (!/^1[3|4|5|7|8|9][0-9]\d{8}$/.test( mobile ) ) {
               	showError('手机号格式不正确');
               	return false;
           	}
            //This.autoStart();					
            This.$obj.prop( 'disabled' , true ).html('发送中...');
            $.ajax({
                type: this.opts.type,
                data: this.opts.data,
                dataType:'json',
                url: this.opts.url
            }).done( function ( data ){
                if( data.status == 1){
                    This.autoStart();
                }else{
                    This.$obj.prop( 'disabled' , false ).html('获取验证码');
                    showError( data.mes );
                }
            }).fail( function(){
                This.$obj.prop( 'disabled' , false ).html('获取验证码');

            })
        },

        autoStart : function  (){
            var This = this;
            this.$obj.addClass( 'disabled' ).prop( 'disabled' , true );
            function _auto (){
                if( This.interval >0){
                    This.interval--;
                    This.$obj.html( This.opts.text.replace( /X/g ,This.interval ) );
                    This.timmer = setTimeout( _auto , 1000 );
                    //This.timmer = setTimeout( This.autoStart , 1000 );
                } else {
                    clearTimeout( This.timmer );
                    This.$obj.removeClass( 'disabled' ).html('获取验证码' );
                    This.$obj.prop( 'disabled' , false );
                }
            }
            _auto();
        }

    }


    $.fn.sendCode = function ( opt ){
        return this.each(function(index, el) {
            new SendCode( this , opt )
        });
    }

}( window , $ );