<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!----指定设备为手机设备---->
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <!----------------------->
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/weui.css')}}">
    <link rel="stylesheet" href="{{asset('css/my_app.css')}}">
</head>
<body>
<!---weiui(需要加入div.page来进行包裹)--->
<div class="page">
    @section('content')
    @show
</div>
<!----------------------------------->

<!----------tooltips（公共标签，弹框提示）--------->
<div class="bk_toptips"><span></span></div>
    <!-----通用弹框代码---------
    $('.bk_toptips').show();
    $('.bk_toptips span').html('各种类型提示');
    setTimeout(function(){$('.bk_toptips').hide();},2000);
    ------------------------->
<!--------------------------------------------->
<a id="showIOSActionSheet"><div id="global_menu"><div></div></div></a>

<!--BEGIN actionSheet-->
<div>
    <div class="weui-mask" id="iosMask" style="display: none"></div>
    <div class="weui-actionsheet" id="iosActionsheet">
        <div class="weui-actionsheet__menu">
            <div class="weui-actionsheet__cell" onclick="onMenuItemClick(1)">用户中心</div>
            <div class="weui-actionsheet__cell" onclick="onMenuItemClick(2)">产品展示</div>
            <div class="weui-actionsheet__cell" onclick="onMenuItemClick(3)">购物车</div>
            <div class="weui-actionsheet__cell" onclick="onMenuItemClick(4)">关于我们</div>
        </div>
        <div class="weui-actionsheet__action">
            <div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div>
        </div>
    </div>
</div>

</body>
<script src="{{asset('js/jquery-1.11.2.min.js')}}"></script>
<!---此段js为弹框使用-->
<script type="text/javascript">
    // ios
    $(function(){
        var $iosActionsheet = $('#iosActionsheet');
        var $iosMask = $('#iosMask');

        function hideActionSheet() {
            $iosActionsheet.removeClass('weui-actionsheet_toggle');
            $iosMask.fadeOut(200);
        }

        $iosMask.on('click', hideActionSheet);
        $('#iosActionsheetCancel').on('click', hideActionSheet);
        $("#showIOSActionSheet").on("click", function(){
            $iosActionsheet.addClass('weui-actionsheet_toggle');
            $iosMask.fadeIn(200);
        });
    });

    function onMenuItemClick(index) {
        $('#iosActionsheet').removeClass('weui-actionsheet_toggle');
        $('#iosMask').fadeOut(200);
        if(index == 1) {

        } else if(index == 2) {

        } else if(index == 3){

        } else {
            $('.bk_toptips').show();
            $('.bk_toptips span').html("敬请期待!");
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
        }
    }
</script>

@section('my-js')
@show
</html>