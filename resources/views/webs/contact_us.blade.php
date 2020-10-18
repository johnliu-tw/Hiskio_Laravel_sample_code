@extends('layouts.app')

@section('content')
  <h3>聯絡我們</h3>
  <form action="">
    請問你是: <input type="text"> <br>
    你的消費時間: <input type="date"><br>
    你消費商品的種類: 
    <select>
      <option value="物品">物品</option>
      <option value="食品">食品</option>
    </select><br>
    <button>送出</button>
  </form>
@endsection
