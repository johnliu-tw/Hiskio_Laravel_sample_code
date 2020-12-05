@extends('layouts.app')

@section('content')
  <h3>聯絡我們</h3>
  <form action="">
    <div class="form-group">
      <label >請問你是:</label>
      <input class="form-control">
    </div>
    <div class="form-group">
      <label >你的消費時間:</label>
      <input type='date' class="form-control">
    </div>
    <div class="form-group">
      <label >你消費商品的種類:</label>
      <select  class="form-control">
        <option value="物品">物品</option>
        <option value="食品">食品</option>
      </select>
    </div>
    <button class="btn btn-primary">送出</button>
  </form>
@endsection
