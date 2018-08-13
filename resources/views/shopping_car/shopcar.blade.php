@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    {{--@include('shared.messages')--}}

                    <div class="card-body">
                        @if($allGoodsKey)
                            @for($i = 0; $i < count($allGoodsKey); $i++)
                                <p>
                                    商品ID: {{ $allGoodsInfo[$allGoodsKey[$i]]['id'] }} <br>
                                    商品昵称: {{ $allGoodsInfo[$allGoodsKey[$i]]['gname'] }} <br>
                                    商品价格: {{ $allGoodsInfo[$allGoodsKey[$i]]['price'] }} <br>
                                    商品数量: {{ $allGoodsNum[$allGoodsKey[$i]] }} <br>
                                    商品总价: {{ $allGoodsNum[$allGoodsKey[$i]] * $allGoodsInfo[$allGoodsKey[$i]]['price'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <a href={{ route('shopping.shop_add', $allGoodsInfo[$allGoodsKey[$i]]['id']) }}>+增加</a>&nbsp;&nbsp;
                                    <a href={{ route('shopping.shop_del', $allGoodsInfo[$allGoodsKey[$i]]['id']) }}>-减少</a>&nbsp;&nbsp;
                                    <a href={{ route('shopping.shop_clean', $allGoodsInfo[$allGoodsKey[$i]]['id']) }}>清除</a>&nbsp;&nbsp;
                                </p>
                            @endfor

                        @else
                            <h2>购物车空空如也~</h2>
                        @endif
                    </div>
                    <div class="card-body">
                        <a href={{ route('home') }}>去购物</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection