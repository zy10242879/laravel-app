@extends('master')

@section('title', '订单提交')

@section('content')
    <div class="page bk_content" style="top: 0;">
        <div class="weui-cells">
            @foreach($cart_items_array as $cart_item)
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <img style="width: 3em" src="{{$cart_item->product->preview}}" alt="" class="bk_icon">
                    </div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <p class="bk_summary">{{$cart_item->product->name}}</p>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="bk_price">{{$cart_item->product->price}}</span>
                        <span> x </span>
                        <span class="bk_important">{{$cart_item->count}}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="weui-cells__title">支付方式</div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd weui-cell_primary">
                    <select class="weui-select" name="payway">
                        <option selected="" value="1">支付宝</option>
                        <option value="2">微信</option>
                    </select>
                </div>
            </div>
        </div>

        <form action="/service/alipay" id="alipay" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="total_price" value="{{$total_price}}" />
            <input type="hidden" name="name" value="@{{$name}}" />
            <input type="hidden" name="order_no" value="@{{$order_no}}" />
        </form>

        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>总计:</p>
                </div>
                <div class="weui-cell__ft bk_price" style="font-size: 25px;">￥ {{$total_price}}</div>
            </div>
        </div>
    </div>
    <div class="bk_fix_bottom">
        <div class="bk_btn_area">
            <button class="weui-btn weui-btn_primary" onclick="_onPay();">提交订单</button>
        </div>
    </div>
@endsection

@section('my-js')

@endsection