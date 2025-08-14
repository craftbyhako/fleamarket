@extention('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}?v={{ time() }}">
@endsetion 

@section('content')
<div class="sell__content">
    <h2 class="sell__title">商品の出品</h2>
    
    <div class="sell__image--group">
        <form class="sell__image--form" action="" enctype="multipart/form-data">
            <h3 class="sell__label">商品画像</h3>
            <label class="sell__image-upload-button" for="file-upload">画像を選択する</label>
            <input type="file" id="file-upload" name="file">
        </form>
    </div>

    <div class="sell__detail--group">
        <form class="sell__detail--form" action="">
            <p class="sell__detail--title">商品の詳細</p>

                <h3 class="sell__label">カテゴリー</h3>
                <!-- ラジオボタン式 -->

                <h3 class="sell__label">商品の状態</h3>
                <select name="condition" id="condition" >
                    <option value="" selected disabled>選択してください</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>

            <p class="sell__detail--title">商品名と説明</p>
                <label class="sell__label" for="item__name">商品名</label>
                <input class="sell__input-form" type="text" name="item_name">

                <label class="sell__label" for="brand">ブランド名</label>
                <input class="sell__input-form" type="text" name="brand">

                <label class="sell__label" for="description">商品の説明</label>
                <input class="sell__input-form" type="text" name="description">

                <label class="sell__label" for="price">販売価格</label>
                <input class="sell__input-form" type="text" name="price">
        </form>

        <form action="">
            <button type="submit">出品する</button>
        </form>



    </div>

</div>









@endsection