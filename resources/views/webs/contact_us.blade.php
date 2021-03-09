@extends('layouts.app')

@section('content')
  <h3>聯絡我們</h3>
  <form action="">
    <div class="form-group">
      <label >請問你是:</label>
      <input name="name" class="form-control">
    </div>
    <div class="form-group">
      <label >你的消費時間:</label>
      <input name="time" type='date' class="form-control">
    </div>
    <div class="form-group">
      <label >你消費商品的種類:</label>
      <select name="product"  class="form-control">
        <option value="物品">物品</option>
        <option value="食品">食品</option>
      </select>
    </div>
    <button class="btn btn-primary">送出</button>
  </form>
@endsection
