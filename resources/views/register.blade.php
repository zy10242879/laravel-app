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
        <!---------手机注册此处验证码省略，看实际项目大小而定是否需要添加-----------
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
            <div class="weui-cell__bd weui-cell-primary">
                <input class="weui-input" type="number" placeholder="请输入验证码"/>
            </div>
            <div class="weui-cell__ft">
                <img src="{{url('service/validateCode')}}" class="bk_validate_code weui-vcode-img"/>
            </div>
        </div>
        -->
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
                <img src="{{url('service/validateCode')}}" class="bk_validate_code weui-vcode-img"/>
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
    //点击验证码图片后更换验证码
    $('.bk_validate_code').click(function () {
        $(this).attr('src','{{url('service/validateCode').'?random='}}'+Math.random());
    });
    //点击更换注册用户方式
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
<script>
    //ajax验证短信是否发送成功，限制发送间隔
    //------------间隔限制----------
    var enable = true;//定义开关，是否允许发送短信
    $('.bk_phone_code_send').click(function () {
        if(enable == false){ //开关为关时，不允许发送短信直接返回
            return;
        }
        //------------对手机号进行验证---------
        var phone = $('input[name=phone]').val();
        // 手机号不为空
        if(phone == '') {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('请输入手机号');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
        }
        // 手机号格式
        if(phone.length != 11 || phone[0] != '1') {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('手机格式不正确');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
        }
        //-----------------------------------
        enable = false;//将开关设定为不允许发送(点击后关闭开关)
        var num = 60;//允许多长时间进行发送
        //定义计时器，60秒后允许发送第2次 function(){逻辑处理},倒计时时间1秒钟
        var interval = window.setInterval(function () {
            //如果没到60秒，多少秒后可以重新发送
            $('.bk_phone_code_send').html(--num +'s 重新发送');
            $('.bk_phone_code_send').removeClass('bk_important');//移除字体  （美化作用）
            $('.bk_phone_code_send').addClass('bk_summary');//添加其它样式字体 （美化作用）
            if(num == 0){ //60秒到了，开关打开，允许发送短信，清除计时器
                enable = true;
                window.clearInterval(interval);//销毁计时器
                $('.bk_phone_code_send').html('重新发送');//将按钮变为'重新发送'
                $('.bk_phone_code_send').removeClass('bk_summary');//移除字体  （美化作用）
                $('.bk_phone_code_send').addClass('bk_important');//添加其它样式字体 （美化作用）
                }
            },1000);
    //-----------ajax发送短信--------------

        $.ajax({
            url:'service/smsCode',
            dataType:'json',
            cache:false,
            data:{phone:phone},
            success:function (data) {//处理短信发送成功于否的逻辑
                if(data == null){ //如果data是空的，那就是服务端返回的数据出现问题
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误！');
                    setTimeout(function(){$('.bk_toptips').hide();},2000);
                    return;
                }
                if(data.status != 0){//如果data中的状态不为0，输出错误信息
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html(data.message);
                    setTimeout(function(){$('.bk_toptips').hide();},2000);
                    num = 10;//报错后设置10秒后可继续发送
                    return;
                }
                //如果data.status为0，给提示短信发送成功
                $('.bk_toptips').show();
                $('.bk_toptips span').html('发送成功！');
                setTimeout(function(){$('.bk_toptips').hide();},2000);
            },
            error:function (xhr,status,errors) {//出错调试，下以为固定写法
                console.log(xhr);
                console.log(status);
                console.log(errors);
            }
        });
    //------------------------------------
    });
</script>
@endsection