@extends('master')

@section('title','登录')

@section('content')
    <div class="weui-cells-title"></div>
    <div class="weui-cells weui-cells-form">
        <div class="weui-cell">
            <div class="weui-cell-hd"><label class="weui-label">帐号</label></div>
            <div class="weui-cell-bd weui-cell-primary">
                <input class="weui-input" type="tel" placeholder="邮箱或手机号"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell-hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell-bd weui-cell-primary">
                <input class="weui-input" type="tel" placeholder="不少于6位"/>
            </div>
        </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
            <div class="weui-cell__bd weui-cell-primary">
                <input class="weui-input" type="number" placeholder="请输入验证码"/>
            </div>
            <div class="weui-cell__ft">
                <img src="{{url('validateCode')}}" class="bk_validate_code weui-vcode-img"/>
            </div>
        </div>
    </div>
    <div class="weui-cells-tips"></div>
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" onclick="onLoginClick();">登录</a>
    </div>
    <a href="/register" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>
@endsection

@section('my-js')
<script>
    $('.bk_validate_code').click(function () {
        $(this).attr('src','{{url('validateCode').'?random='}}'+Math.random());
    });
</script>
@endsection