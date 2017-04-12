@extends('layouts.app')

@section('style')
@endsection

@section('content')
{{--  {{ dd($orders->items()) }}--}}
  <h1>주문 목록</h1>
  <table class="table table-striped table-responsive">
    <tr>
      <th>주문번호</th>
      <th>주문자</th>
      <th>배송지</th>
      <th>상품</th>
      <th>전체 구매 금액</th>
      <th>배송비</th>
      <th>결제 방법</th>
      <th>송장번호</th>
    </tr>
    @forelse($orders as $order)
      <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->customer->name }} ({{ $order->customer->phone_number }}, {{ substr($order->customer->gender, 0, 1) }})</td>
        <td>{{ $order->customer->address }}</td>
        <td>{{ ($order->products_count) ? $order->products->first()->title : null }}</td>
        <td>{{ number_format($order->billable_amount) }}원</td>
        <td>{{ number_format($order->billable_delivery_fee) }}원</td>
        <td>{{ $order->payment_method }}</td>
        <td>{{ ($delivery = $order->delivery) ? $delivery->id : null }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center text-danger">
          최근 주문이 없습니다.
        </td>
      </tr>
    @endforelse
  </table>
  <div class="text-center">
    {!! $orders->links() !!}
  </div>
@endsection

@section('script')
@endsection