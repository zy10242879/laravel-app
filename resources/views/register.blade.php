@extends('master')

@section('title','用户注册')

@section('content')
    <div class="weui-cells__title">注册方式</div>
    <div class="weui-cells weui-cells_radio">
        <label class="weui-cell weui-check__label" for="x11">
            <div class="weui-cell__bd">
                <p>手机号注册</p>
            </div>
            <div class="weui-cell__ft">
                <input onclick="changeRegister(1)" type="radio" class="weui-check" name="register_type" id="x11" checked="checked">
                <span class="weui-icon-checked"></span>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="x12">
            <div class="weui-cell__bd weui-cell_primary">
                <p>邮箱注册</p>
            </div>
            <div class="weui-cell__ft">
                <input onclick="changeRegister(2)" type="radio" class="weui-check" name="register_type" id="x12">
                <span class="weui-icon-checked"></span>
            </div>
        </label>
    </div>
    <div id="phone" class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
            <div class="weui-cell__bd weui-cell_primary">
                <input class="weui-input" type="number" placeholder="" name="phone"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell__bd weui-cell_primary">
                <input class="weui-input" type="password" placeholder="不少于6位" name='passwd_phone'/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
            <div class="weui-cell__bd weui-cell_primary">
                <input class="weui-input" type="password" placeholder="不少于6位" name='passwd_phone_cfm'/>
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
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">手机验证码</label></div>
            <div class="weui-cell__bd weui-cell_primary">
                <input class="weui-input" type="number" placeholder="" name='phone_code'/>
            </div>
            <p class="bk_important bk_phone_code_send">发送验证码</p>
            <div class="weui-cell__ft">
            </div>
        </div>
    </div>
    <div id="email" class="weui-cells weui-cells_form" style="display: none;">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">邮箱</label></div>
            <div class="weui-cell__bd weui-cell_primary">
                <input class="weui-input" type="text" placeholder="" name='email'/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell__bd weui-cell_primary">
                <input class="weui-input" type="password" placeholder="不少于6位" name='passwd_email'>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
            <div class="weui-cell__bd weui-cell_primary">
                <input class="weui-input" type="password" placeholder="不少于6位" name='passwd_email_cfm'/>
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
    <div class="weui-cells__tips"></div>
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" onclick="onRegisterClick();">注册</a>
    </div>
    <a href="{{url('login')}}" class="bk_bottom_tips bk_important">已有帐号? 去登录</a>
@endsection

@section('my-js')
    <script>
        $('.bk_validate_code').click(function () {
            $(this).attr('src','{{url('validateCode').'?random='}}'+Math.random());
        });
        function changeRegister(index) {
            if(index==1){
              $('#phone').attr('style','display:');
              $('#email').attr('style','display:none');
            }else if(index==2){
                $('#phone').attr('style','display:none');
                $('#email').attr('style','display:');
            }
        }
    </script>
@endsection