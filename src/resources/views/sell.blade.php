@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}?v={{ time() }}">
@endsection 

@section('content')
<div class="sell__content">
    <h2 class="sell__title">商品の出品</h2>
    
    <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="sell__image--group">
            <h3 class="sell__label">商品画像</h3>
            <label class="sell__image-upload-button" for="file-upload">画像を選択する</label>
            <input type="file" id="file-upload" name="file">
        </div>

        <div class="sell__detail--group">
            <p class="sell__detail--title">商品の詳細</p>

                <h3 class="sell__label">カテゴリー</h3>
                @foreach($allCategories as $category)
                    <label>
                        <!-- <pre>{{ print_r($allCategories, true) }}</pre> -->
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        {{ $category->category_name }}
                    </label>
                @endforeach

                <h3 class="sell__label">商品の状態</h3>
                <select name="condition" id="condition" >
                    <option value="" selected disabled>選択してください</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>

            <p class="sell__detail--title">商品名と説明</p>
                <label class="sell__label" for="item_name">商品名</label>
                <input class="sell__input-form" type="text" name="item_name">

                <label class="sell__label" for="brand">ブランド名</label>
                <input class="sell__input-form" type="text" name="brand">

                <label class="sell__label" for="description">商品の説明</label>
                <input class="sell__input-form" type="text" name="description">

                <label class="sell__label" for="price">販売価格</label>
                <input class="sell__input-form" type="text" name="price" placeholder="￥">
        </div>
        
        <button type="submit">出品する</button>
        
    </form>
</div>
@endsection