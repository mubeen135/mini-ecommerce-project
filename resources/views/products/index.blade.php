@extends('layouts.app')

@section('content')
  <h1>Products</h1>
  <div class="row">
    @foreach($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text"><strong>${{ number_format($product->price, 2) }}</strong></p>
            <button class="btn btn-primary add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection