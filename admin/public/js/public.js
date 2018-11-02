/*一些公共方法 ，和扩展方法*/
var nuoyhFunction = {};  //全局变量 不要改动
$.fn.serializeObject = function() { //针对jq 方法的扩展 生成 json格式的 form数据
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

Array.prototype.remove = function (val) { //对数组方法的扩展，删除某一个；
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};

nuoyhFunction.objDeepCopy = function(source){ //针对  对象的深拷贝
    var sourceCopy = {};
    for (var item in source) sourceCopy[item] = typeof source[item] === 'object' ? objDeepCopy(source[item]) : source[item];
    return sourceCopy;
}


