@extends('layouts.app')

@section('content')
  <div class="text-center">
    <h1>Payment Cancelled</h1>
    <p>Your payment was cancelled. You can try again.</p>
    <a href="{{ route('cart.index') }}" class="btn btn-primary">Return to Cart</a>
  </div>
@endsection