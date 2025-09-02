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
            <div class="sell__image-wrapper">
                <label class="sell__image-upload-button" for="file-upload">画像を選択する</label>
                <input type="file" id="file-upload" name="image" hidden>
                <p class="sell__error-message">
                    @error('image')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="sell__detail--group">
            <h2 class="sell__detail--title">商品の詳細</h2>

                <h3 class="sell__label">カテゴリー</h3>
                @foreach($allCategories as $category)
                    <label class="category-option">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <span>{{ $category->category_name }}</span>
                    </label>
                @endforeach
                        <p class="sell__error-message">
                        @error('categories')
                            {{ $message }}
                        @enderror
                        </p>

                <h3 class="sell__label">商品の状態</h3>
                <select class="condition-select" name="condition_id" id="condition" >
                    <option value="" selected disabled {{ old('condition_id') ? '' : 'selected' }}>選択してください</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}" 
                        {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->condition }}
                        </option>
                    @endforeach
                </select>
                <p class="sell__error-message">
                    @error('condition_id')
                        {{ $message }}
                    @enderror
                </p>

            <h2 class="sell__detail--title">商品名と説明</h2>
                <label class="sell__label" for="item_name">商品名</label>
                <input class="sell__input-form" type="text" name="item_name" value="{{ old('item_name') }}">
                    <p class="sell__error-message">
                    @error('item_name')
                        {{ $message }}
                    @enderror
                </p>

                <label class="sell__label" for="brand">ブランド名</label>
                <input class="sell__input-form" type="text" name="brand" value="{{ old('brand') }}">


                <label class="sell__label" for="description">商品の説明</label>
                <textarea class="sell__input-form" type="text" name="description">{{ old('description') }}</textarea>
                    <p class="sell__error-message">
                    @error('description')
                        {{ $message }}
                    @enderror
                    </p>

                <label class="sell__label" for="price">販売価格</label>
                <input class="sell__input-form" type="text" name="price" placeholder="￥" value="{{ old('price') }}">
                    <p class="sell__error-message">
                    @error('price')
                        {{ $message }}
                    @enderror
                </p>
        </div>
        
        <button class="sell__submit-button" type="submit">出品する</button>
        
    </form>
</div>
@endsection