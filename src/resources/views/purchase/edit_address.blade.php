@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/edit_address.css')}}?v={{ time() }}">

@endsection

@section('content')

<div class= "destination__content">
    <h2 class="destination__title">住所の変更</h2>
    <br>
    <form class="destination-form" action="{{ route('purchase.updateDestination', ['item_id' => $item->id]) }}" method="POST" >
        @csrf
        @method('PATCH')
        <div class="destination__input-form">
            <label class="destination__label" for="destination_postcode">郵便番号</label>
            <input class="destination__input" type="text" name="destination_postcode" value="{{ old('destination_postcode') }}" >
                <p class="destination__error-message">
                @error('destination_postcode')
                {{ $message }}
                @enderror
                </p>

            <label class="destination__label" for="destination_address">住所</label>
            <input class="destination__input" type="text" name="destination_address" value="{{ old('destination_address') }}" >
                <p class="destination__error-message">
                @error('destination_address')
                {{ $message }}
                @enderror
                </p>

            <label class="destination__label" for="building">建物名</label>
            <input class="destination__input" type="text" name="destination_building" value="{{ old('destination_building') }}" >
                <p class="destination__error-message">
                @error('destination_building')
                {{ $message }}
                @enderror
                </p>
        </div>

        <div class="destination__input-form__button">
            <button type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection