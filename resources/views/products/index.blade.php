@extends('layouts.app')

@section('style')
  <style>
    ul {
      list-style: none;
      padding-left: 0;
    }

    .row img {
      margin-bottom: 1em;
    }
  </style>
@endsection

@section('content')
  <h1>상품 목록</h1>

  @foreach ($products->chunk(3) as $chunk)
    <ul class="row">
      @foreach ($chunk as $product)
        <li class="col-sm-4">
          <h4>
            <a href="{{ route('products.show', $product->id) }}">
              {{ str_limit($product->title, 40) }}
            </a>
          </h4>
          <div>
            @if ($image = $product->images->first())
              <a href="{{ route('products.show', $product->id) }}">
                <img src="{{ asset("storage/product_images/{$image->filename}") }}"
                     class="img-responsive">
              </a>
            @endif
          </div>
          <div>
            @if (Auth::guard('customers')->check())
              <button data-product-id="{{ $product->id }}"
                      class="btn btn-xs btn-primary pull-right">
                담기
              </button>
            @endif
            <ul>
              <li>
                {{ number_format($product->price) }}원
              </li>
            </ul>
          </div>
        </li>
      @endforeach
    </ul>
  @endforeach

  <div class="text-center">
    {!!  $products->links() !!}
  </div>
@endsection

@section('script')
  <script>
    $(".btn-xs").on("click", function (e) {
      var self = $(this);

      $.ajax({
        type: "POST",
        url: "{{ route('carts.store') }}",
        data: {
          _token: Laravel.csrfToken,
          product_id: self.data("product-id")
        }
      }).then(function (data) {
        //
      });
    });
  </script>
@stop
