@extends('layouts.admin_app')
@section('content')
<h2 >產品列表</h2>
<span>產品總數: {{ $productCount }} </span>
<div>
  <input class="import" type="button" value="匯入 Excel"">
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (isset($success))
    <div class="alert alert-success">
        {{ $success }}
    </div>
@endif
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
        <td>
          @if($product->image_url)
            <a href="{{ $product->image_url}}">圖片連結</a>
          @endif
        </td>
        <td>
          <input class="upload_image btn-circle btn-primary" data-id="{{$product->id}}" type="button" value="上傳">
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div>
  @for ($i = 1; $i <= $productPages; $i++)
      <a href="/admin/products?page={{ $i }}">第 {{ $i }} 頁</a> &nbsp;
  @endfor
</div>


<!-- Modal -->
<div class="modal fade" id="upload_image" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4>上傳圖片</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/admin/products/uploadImage" method="post" enctype=multipart/form-data>
          <input type="hidden" id="product_id" name="product_id">
          <input type="file" id="product_image" name="product_image">
          <input type="submit" value="送出">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="import" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4>上傳Excel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/admin/products/import" method="post" enctype=multipart/form-data>
          <input type="file" id="excel" name="excel">
          <input type="submit" value="送出">
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('.upload_image').click(function(){
    $('#product_id').val($(this).data('id'))
    $('#upload_image').modal()
  })
  $('.import').click(function(){
    $('#import').modal()
  })
</script>
@endsection