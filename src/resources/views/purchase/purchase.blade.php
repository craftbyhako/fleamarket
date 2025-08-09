@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}?v={{ time() }}">

@endsection

@section('content')
{{ dd($item) }}
<div class="purchase">
    <div class="purchase__left-part">
        
        <!-- 購入商品 -->
        <div class="purchase__item">
            <img class="item-img" src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
            <div class="purchase__info">
                <p class="item-name">{{ $item->item_name }}</p>
                <p class="item-price">￥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <!-- 支払い方法 -->
        <div class="payment">
            <form action="{{ route('purchase.form', ['item' => $item->id]) }}" method="get">
                <p>支払い方法</p>
                <select class="payment__select" name="payment" onchange="this.form.submit()" >
                    <option value="" disabled {{ $payment === '' ? 'selected' : '' }}>支払い方法を選択してください</option>
                    <option value="コンビニ払い" {{ $payment === 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="カード支払い" {{ $payment === 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
                </select>
            </form>
        </div>

        <!-- 配送先 -->
        <div class="destination">
            <div class="destination-wrapper">
                <p class="destination__comfirm">配送先 <a href="{{ route('purchase.showDestination', ['item_id' => $item->id]) }}" class="change-link">変更する</a></p>
                    <div class="user-address">
                        <p>〒{{ $address['postcode'] }}</p>
                        <p>{{ $address['address'] }}</p>
                        <p>{{ $address['building'] }}</p>
                    </div>
            </div>   
        </div>

    </div>
 <!-- _________________________________________ -->

    <div class="purchase__right-part">
        <table class="purchase__summary">
            <tr class = "summary-row">
                <th>商品代金</th>
                <td>￥{{ number_format($item->price) }}</td>
            </tr>

            <tr>
                <th>支払い方法</th>
                <td>{{ $payment ?: '未選択' }}</td>
            </tr>
        </table>

        <div class="purchase">
            <form action="{{ route('purchase.store', ['Item_id' => $item->id]) }}" method="POST">
                @csrf
                <button class="purchase__button" type="submit">購入する</button>
            </form>
        </div>
    </div>
</div>
@endsection