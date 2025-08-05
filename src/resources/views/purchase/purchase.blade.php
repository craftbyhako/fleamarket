@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}?v={{ time() }}">

@endsection

@section('content')

<div class="purchase">
    <div class="purcahse__left-part">
        
        <!-- 購入商品 -->
        <div class="purchase__item">
            <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
            <h2>{{ $item->item_name }}</h2>
            <h3>￥{{ $item->price }}</h3>
        </div>

        <!-- 支払い方法 -->
        <div class="payment">
            <form action="">
                <p>支払い方法</p>
                <select name="payment" id="" placeholder="選択してください">
                    <option value="1">コンビニ払い</option>
                    <option value="2">カード支払い</option>
                </select>
            </form>
        </div>

        <!-- 配送先 -->
        <div class="destination">
            <div class="destination-wrapper">
                <div class="destination__comfirm">配送先
                    <div>{{ $user->postcode }}</div>
                    <div>{{ $user->address }}</div>
                    <div>{{ $user->building }}</div>
                </div>
                <p class="destination__edit">変更する</p>
            </div>   
        </div>

    </div>
 <!-- _________________________________________ -->

    <div class="purcahse__right-part">
        <table class="purchase__summary">
            <tr>
                <th>商品代金</th>
                <td>{{ $item->price }}</td>
            </tr>

            <tr>
                <th>支払い方法</th>
                <td>{{ $item->name }}</td>
            </tr>
        </table>

        <button class="purchase__button" type="submit">購入する</button>
    </div>







</div>
@endsection