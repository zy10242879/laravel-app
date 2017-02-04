@extends('master')

@section('title','登录')

@section('content')
    <div class="weui-cells__title"></div>
    <div class="weui-cells weui-cells-form">
        <div class="weui-cell">
            <div class="weui-cell-hd"><label class="weui-label">帐号</label></div>
            <div class="weui-cell-bd weui-cell-primary">
                <input class="weui-input" type="tel" name="username" placeholder="邮箱或手机号"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell-hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell-bd weui-cell-primary">
                <input class="weui-input" type="password" name="password" placeholder="不少于6位"/>
            </div>
        </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
            <div class="weui-cell__bd weui-cell-primary">
                <input class="weui-input" type="text" name="validateCode" placeholder="请输入验证码"/>
            </div>
            <div class="weui-cell__ft">
                <img src="{{url('service/validateCode')}}" class="bk_validate_code weui-vcode-img"/>
            </div>
        </div>
    </div>
    <div class="weui-cells-tips"></div>
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" onclick="onLoginClick();">登录</a>
    </div>
    <a href="{{url('register')}}" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>
@endsection

@section('my-js')
<script>
    $('.bk_validate_code').click(function () {
        $(this).attr('src','{{url('service/validateCode').'?random='}}'+Math.random());
    });
</script>
<script>
    function onLoginClick() {
        // 帐号
        var username = $('input[name=username]').val();
        if(username.length == 0) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('帐号不能为空');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
        }
        if(username.indexOf('@') == -1) { //手机号
            if(username.length != 11 || username[0] != 1) {
                $('.bk_toptips').show();
                $('.bk_toptips span').html('帐号格式不对!');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }
        } else {
            if(username.indexOf('.') == -1) {
                $('.bk_toptips').show();
                $('.bk_toptips span').html('帐号格式不对!');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }
        }
        // 密码
        var password = $('input[name=password]').val();
        if(password.length == 0) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('密码不能为空!');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
        }
        if(password.length < 6) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('密码不能少于6位!');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
        }
        // 验证码
        var validateCode = $('input[name=validateCode]').val();
        if(validateCode.length == 0) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('验证码不能为空!');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
        }
        if(validateCode.length < 4) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('验证码不能少于4位!');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
        }
        $.ajax({
            type: "POST",
            url: '/service/login',
            dataType: 'json',
            cache: false,
            data: {username: username, password: password, validateCode: validateCode, _token: "{{csrf_token()}}"},
            success: function(data) {
                if(data == null) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
                if(data.status != 0) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html(data.message);
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }

                $('.bk_toptips').show();
                $('.bk_toptips span').html(data.message);
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                //成功登录后，前端跳转页面
                location.href = "{{url('category')}}";

            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    }
</script>
@endsection