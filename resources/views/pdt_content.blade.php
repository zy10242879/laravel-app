@extends('master')

@section('title', $product->name)

@section('content')
<link rel="stylesheet" href="{{asset('css/swipe.css')}}">
    <div class="page bk_content" style="top: 0;">
        <div class="addWrap">
            <div class="swipe" id="mySwipe">
                <div class="swipe-wrap">
                    @foreach($pdt_images as $pdt_image)
                        <div>
                            <a href="javascript:;"><img class="img-responsive" src="{{$pdt_image->image_path}}" /></a>
                        </div>
                    @endforeach
                </div>
            </div>
            <ul id="position">
                @foreach($pdt_images as $index => $pdt_image)
                    <li class={{$index == 0 ? 'cur' : ''}}></li>
                @endforeach
            </ul>
        </div>

        <div class="weui-cells__title">
            <span class="bk_title">{{$product->name}}</span>
            <span class="bk_price" style="float: right;color: red;font-weight: bold;">￥ {{$product->price}}</span>
        </div>
        <div class="weui-cells">
            <div class="weui-cell">
                <p class="bk_summary">{{$product->summary}}</p>
            </div>
        </div>

        <div class="weui-cells__title">详细介绍</div>
        <div class="weui-cells">
            <div class="weui-cell">
                @if($pdt_content != null)
                    {!! $pdt_content->content !!}
                @else

                @endif
            </div>
        </div>
    </div>

    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui-btn weui-btn_primary" onclick="_addCart();">加入购物车</button>
        </div>
        <div class="bk_half_area" style="float: right;">
            <button class="weui-btn weui-btn_default" onclick="_toCart()">查看购物车(<span id="cart_num" class="m3_price"></span>)</button>
        </div>
    </div>

@endsection

@section('my-js')
    <script src="{{asset('js/swipe.min.js')}}" charset="utf-8"></script>
    <script type="text/javascript">
        //----------------轮播图js---------------
        var bullets = document.getElementById('position').getElementsByTagName('li');
        Swipe(document.getElementById('mySwipe'), {
            auto: 2000,
            continuous: true,
            disableScroll: false,
            callback: function(pos) {
                var i = bullets.length;
                while (i--) {
                    bullets[i].className = '';
                }
                bullets[pos].className = 'cur';
            }
        });
        //---------------------------------------

        {{--function _addCart() {--}}
            {{--var product_id = "{{$product->id}}";--}}
            {{--$.ajax({--}}
                {{--type: "GET",--}}
                {{--url: '/service/cart/add/' + product_id,--}}
                {{--dataType: 'json',--}}
                {{--cache: false,--}}
                {{--success: function(data) {--}}
                    {{--if(data == null) {--}}
                        {{--$('.bk_toptips').show();--}}
                        {{--$('.bk_toptips span').html('服务端错误');--}}
                        {{--setTimeout(function() {$('.bk_toptips').hide();}, 2000);--}}
                        {{--return;--}}
                    {{--}--}}
                    {{--if(data.status != 0) {--}}
                        {{--$('.bk_toptips').show();--}}
                        {{--$('.bk_toptips span').html(data.message);--}}
                        {{--setTimeout(function() {$('.bk_toptips').hide();}, 2000);--}}
                        {{--return;--}}
                    {{--}--}}

                    {{--var num = $('#cart_num').html();--}}
                    {{--if(num == '') num = 0;--}}
                    {{--$('#cart_num').html(Number(num) + 1);--}}

                {{--},--}}
                {{--error: function(xhr, status, error) {--}}
                    {{--console.log(xhr);--}}
                    {{--console.log(status);--}}
                    {{--console.log(error);--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

        {{--function _toCart() {--}}
            {{--location.href = '/cart';--}}
        {{--}--}}
    </script>


@endsection
