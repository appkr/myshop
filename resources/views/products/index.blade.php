@extends('layouts.app')

@section('style')
  <style>
    ul {
      list-style: none;
      padding-left: 0;
    }
  </style>
@endsection

@section('content')
  <h1>상품 목록</h1>

  @foreach ($products->chunk(3) as $chunk)
    <ul class="row">
      @foreach ($chunk as $product)
        <li class="col-xs-4">
          <h4>
            {{ str_limit($product->title, 40) }}
          </h4>
          <div>
            @if ($image = $product->images->first())
              <img src="{{ asset("storage/product_images/{$image->filename}") }}" class="img-responsive">
            @endif
          </div>
          <div>
            <ul>
              <li>{{ number_format($product->price) }}원</li>
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
