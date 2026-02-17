@extends('layouts.app')

@section('content')
  <div class="text-center">
    <h1>Thank You for Your Order!</h1>
    <p>Your order #{{ $order->id }} has been placed successfully.</p>
    <p>A confirmation email has been sent to {{ $order->customer_email }}.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
  </div>
@endsection