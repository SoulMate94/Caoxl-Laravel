@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                {{--@include('shared.message')--}}

                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                <div class="card-body">
                    商品0001<a href="/shopping/add/1">加入购物车</a> <br>
                    商品0002<a href="/shopping/add/2">加入购物车</a> <br/>
                    商品0003<a href="/shopping/add/3">加入购物车</a>
                </div>

                <div class="card-body">
                    <a href="/shopping/shop_car_info">购物车</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
