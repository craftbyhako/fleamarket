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
            <input type="file" id="file-upload" name="image">
        </div>

        <div class="sell__detail--group">
            <p class="sell__detail--title">商品の詳細</p>

                <h3 class="sell__label">カテゴリー</h3>
                @foreach($allCategories as $category)
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                    {{ $category->category_name }}
                @endforeach

                <h3 class="sell__label">商品の状態</h3>
                <select name="condition_id" id="condition" >
                    <option selected disabled>選択してください</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                    @endforeach
                </select>

            <p class="sell__detail--title">商品名と説明</p>
                <label class="sell__label" for="item_name">商品名</label>
                <input class="sell__input-form" type="text" name="item_name" value="{{ old('item_name') }}">

                <label class="sell__label" for="brand">ブランド名</label>
                <input class="sell__input-form" type="text" name="brand" value="{{ old('brand') }}">

                <label class="sell__label" for="description">商品の説明</label>
                <textarea class="sell__input-form" type="text" name="description">{{ old('description') }}</textarea>

                <label class="sell__label" for="price">販売価格</label>
                <input class="sell__input-form" type="text" name="price" placeholder="￥" value="{{ old('price') }}">
        </div>
        
        <button type="submit">出品する</button>
        
    </form>
</div>
@endsection