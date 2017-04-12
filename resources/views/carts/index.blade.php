@extends('layouts.app')

@section('style')
  <style>
  </style>
@endsection

@section('content')
  <h1>장바구니</h1>
  <table class="table table-striped table-responsive">
    <tr>
      <th>카테고리</th>
      <th>상품명</th>
      <th>단가</th>
      <th>수량</th>
      <th>금액</th>
    </tr>
    @forelse($cart->items() as $item)
      <tr>
        <td>{{ $item->category->name }}</td>
        <td>
          <a href="{{ route('products.show', $item->buyableId()) }}">
            {{ str_limit($item->title, 20) }}
          </a>
        </td>
        <td>{{ number_format($item->price) }}원</td>
        <td>{{ $item->quantity() }}</td>
        <td>{{ number_format($item->subTotal()) }}원</td>
      </tr>
    @empty
      <tr>
        <td colspan="5" class="text-center text-danger">
          장바구니에 담긴 상품이 없습니다.
        </td>
      </tr>
    @endforelse
    @if ($cart->items()->count())
      <tr>
        <td colspan="4">총 결제금액</td>
        <td>{{ number_format($cart->total()) }}원</td>
      </tr>
    @endif
  </table>
  <div class="text-center">
    <button id="checkout" class="btn btn-primary">
      결제하기
    </button>
  </div>
@endsection

@section('script')
  <script>
    $("#checkout").on("click", function (e) {
      var self = $(this);

      $.ajax({
        type: "POST",
        url: "{{ route('carts.checkout') }}",
        data: {
          _token: Laravel.csrfToken
        }
      }).then(function (data) {
        console.log(data);
        createOrder(data);
      });
    });

    var createOrder = function (data) {
      $.ajax({
        type: "POST",
        url: "{{ route('customers.orders.store') }}",
        data: {
          _token: Laravel.csrfToken,
          payment_method: data.payment_method
        }
      }).then(function (data) {
        window.location.href = "{{ route('products.index') }}";
      });
    };
  </script>
@stop
