@extends('master')

@section('title','书籍类别')

@section('content')
    <div class="weui-cells__title">选择书籍类别</div>
    <div class="weui-cells weui-cells-split">
        <div class="weui-cell weui-cell_select">
            <div class="weui-cell__bd weui-cell__primary">
                <select class="weui-select" name="category">
                    @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <div class="weui-cells weui-cells-access">
        <a class="weui-cell" href="javascript:;">
            <div class="weui-cell__bd weui-cell__primary">
                <p></p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell" href="javascript:;">
            <div class="weui-cell__bd weui-cell__primary">
                <p></p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>
@endsection

@section('my-js')
<script>
    _getCategory();

    $('.weui-select').change(function(event) {
        _getCategory()
    });

    function _getCategory() {
        var parent_id = $('.weui-select option:selected').val();
        console.log('parent_id: ' + parent_id);
        $.ajax({
            type: "get",
            url: "{{url('service/category/parent_id/')}}/"+parent_id,
            dataType: 'json',
            cache: false,
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
                $('.weui-cells-access').html('');
                for(var i=0; i<data.categorys.length; i++) {
                    //next 根据分类id进行筛选商品，定义路径，去跳转到该分类下，显示分类下的所有商品
                    var next =  '/product/category_id/' + data.categorys[i].id;
                    var node =  '<a class="weui-cell" href="' + next + '">' +
                                '<div class="weui-cell__bd weui-cell__primary">' +
                                '<p>'+ data.categorys[i].name +'</p>' +
                                '</div>' +
                                '<div class="weui-cell__ft"></div>' +
                                '</a>';
                    $('.weui-cells-access').append(node);
                }
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