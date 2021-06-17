let infoArr = {
    1: '<strong>提示!</strong> 用户名不符合要求。',
    2: '<strong>提示!</strong> 两次输入密码不一致。',
    3: '<strong>提示!</strong> 密码必须是大于8位的字母和数字组合。',
    4: '<strong>成功!</strong> 发布成功。',
    5: '<strong>提示!</strong> 用户名或密码不能为空。',
    6: '<strong>成功!</strong> 注册成功，即将刷新页面。',
    7: '<strong>错误!</strong> 登录失败，请检查用户名或密码。',
    8: '<strong>成功!</strong> 登录成功，即将刷新页面。',
    9: '<strong>提示!</strong> 暂不支持此功能。',
    10: '<strong>成功!</strong> 注销成功，即将刷新页面。',
    11: '<strong>成功!</strong> 删除成功，即将刷新页面。',
    12: '<strong>提示!</strong> 用户名已被注册。',
    13: '<strong>错误!</strong> 注册失败，请修改用户名或稍后重试。',
    14: '<strong>错误!</strong> 无法连接服务器。',
    15: '<strong>错误!</strong> 服务器异常，无法连接数据库。'

}

function alert(alertName) {
    let signDanger = $('#' + alertName);

    function showAlert(infoNum , time ) {
        // console.log( infoNum );
        if ( time == undefined){
            time = 1500;
        }
        signDanger.html(infoArr[infoNum]);

        signDanger.show(500);

        setTimeout(
            function () {
                signDanger.hide(500);
            }, time
        )
    }

    return showAlert;
}

function checkUserNameFun(userName) {

    let reUserName = /^[0-9A-Za-z\u4e00-\u9fa5_]+$/;


    return reUserName.test(userName);
    //
    // return true;
}

function shaUserPw(pw) {
    return $.sha1(pw).substring(0, 20);
}

function getURLString(name) {
    // var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    // var r = window.location.search.substr(1).match(reg);
    // if (r != null) return decodeURI(r[2]); return null;
    try {
        f = JSON.parse( unescape(window.location.hash ).substring(1) )[name];
        if ( f == undefined ){
            f = ""
        }
        return f;
    }catch ( SyntaxError ){
        return "";
    }


}