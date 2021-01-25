@extends('layouts.app')
@section('content')
<style>
  body{
    font-size: 16px;
  }
  .special-text{
    text-align: center;
    background-color: yellowgreen;
  }
</style>
<div class="row">
  <h2 class="col-4" style="margin-top: 40px;">商品列表</h2>
  <div class="col-8">
    <img  src="https://images.theconversation.com/files/350865/original/file-20200803-24-50u91u.jpg?ixlib=rb-1.1.0&q=45&auto=format&w=1200&h=1200.0&fit=crop" style="width: 300px;">
  </div>
</div>
<table class="table" style="margin-top:30px;">
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
        <td>
          <a href="www.google.com"><i class="fab fa-apple" style='color: red; font-size: 30px'></i> 商品細節</a>
          <input class='check_product btn btn-success' type='button' value='確認商品數量' data-id="{{ $product->id }}">
          <input class='check_shared_url  btn btn-warning' type='button' value='分享商品' data-id="{{ $product->id }}">
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div id="app" v-cloak>
  <example-component></example-component>
</div>
<script>
  $('.check_product').click(function(){
    $.ajax({
      method: "POST",
      url: "/products/checkProduct",
      data: { id: $(this).data('id')}
    })
    .done(function( msg ) {
      if(msg){
        alert('商品數量充足')
      }
      else{
        alert('商品數量不足')
      }
    });
  })
  $('.check_shared_url').click(function(){
    $.ajax({
      method: "Get",
      url: `/products/${$(this).data('id')}/sharedUrl`,
    })
    .done(function( msg ) {
      alert('請分享此縮網址:' + msg.url)
    });
  })
</script>
@endsection