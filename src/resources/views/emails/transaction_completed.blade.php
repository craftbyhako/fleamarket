<!DOCTYPE html>
<html lang="ja">

<body>
    <!-- 出品者 -->
    <p>{{ $item->user->user_name }}様</p>

    <p>いつもFleamarketをご利用いただき、誠にありがとうございます。</p>
    <br>
    <p>購入者：{{ $buyer->user_name }}さんが、<br>
        あなたの商品「　{{ $item->item_name }}　」のお取引を完了しました。
    </p>
    <br>
    <p>ログインの上、お取引画面にて購入者の評価をお願いします。</p>

</body>

</html>