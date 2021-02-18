これは{{ config('app.name', 'Laravel') }}のテストメールです。<br>
<br>
この度はご購入ありがとうございます。<br>
<br>
お届け先<br>
郵便番号：{{$data['address']['zip_code']}}<br>
都道府県：{{$data['address']['pref']}}<br>
市区町村：{{$data['address']['city']}}<br>
番地など：{{$data['address']['street']}}<br>
<br>
ご注文商品一覧<br>
@foreach ($data['items'] as $item)
商品名：{{$item['product']['name']}}<br>
商品価格：{{$item['product']['price']}}<br>
注文個数：{{$item['quantity']}}<br>
<br>
@endforeach
<br>
合計金額：{{$total}}円<br>
<br>
入金が確認され次第、発送いたします。<br>
