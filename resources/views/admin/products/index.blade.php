@extends('layouts.admin_app')
@section('content')
<h2 >產品列表</h2>
<span>產品總數: {{ $productCount }} </span>
<table>
  <thead>
    <tr>
      <td>編號</td>
      <td>標題</td>
      <td>內容</td>
      <td>價格</td>
      <td>數量</td>
      <td>圖片</td>
      <td>功能</td>
    </tr>
  </thead>
  <tbody>
    @foreach( $products as $product )
      <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->title}}</td>
        <td>{{ $product->content}}</td>
        <td>{{ $product->price}}</td>
        <td>{{ $product->quantity}}</td>
        <td></td>
        <td></td>
      </tr>
    @endforeach
  </tbody>
</table>
<div>
  @for ($i = 1; $i <= $productPages; $i++)
      <a href="/admin/products?page={{ $i }}">第 {{ $i }} 頁</a> &nbsp;
  @endfor
</div>
@endsection