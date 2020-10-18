<div>
  <a href="/">商品列表</a>
  <a href="/contactUs">聯絡我們</a>
</div>
<h2>商品列表</h2>
<img src="https://pbs.twimg.com/profile_images/737359467742912512/t_pzvyZZ_400x400.jpg" alt="">
<table>
  <thead>
    <tr>
      <td>標題</td>
      <td>內容</td>
      <td>價格</td>
      <td></td>
    </tr>
  </thead>
  <tbody>
    @foreach( $products as $product )
      @if ( $product->id != 1 )
        <tr>
          <td>{{ $product->title }}</td>
          <td>{{ $product->content }}</td>
          <td>{{ $product->price }}</td>
          <td><a href="www.google.com">商品細節</a></td>
        </tr>
      @endif
    @endforeach
  </tbody>
</table>