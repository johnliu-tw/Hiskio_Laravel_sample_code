<style>
  body{
    font-size: 16px;
  }
  .special-text{
    text-align: center;
    background-color: yellowgreen;
  }
</style>
<div>
  <a href="/">商品列表</a>
  <a href="/contactUs">聯絡我們</a>
</div>
<h2 style="margin-top: 40px;">商品列表</h2>
<img src="https://images.theconversation.com/files/350865/original/file-20200803-24-50u91u.jpg?ixlib=rb-1.1.0&q=45&auto=format&w=1200&h=1200.0&fit=crop" style="width: 300px;">
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
      <tr>
        <td class="{{ $product->id == 1 ? 'special-text' : '' }}">{{ $product->title }}</td>
        <td>{{ $product->content }}</td>
        <td style="{{ $product->price < 600 ? 'color:red; font-size:22px' : ''  }}" >{{ $product->price }}</td>
        <td><a href="www.google.com">商品細節</a></td>
      </tr>
    @endforeach
  </tbody>
</table>