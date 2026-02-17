@extends('layouts.app')

@section('content')
  <h1>Shopping Cart</h1>

  @if(empty($cart))
    <p>Your cart is empty.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
  @else
    <table class="table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cart as $id => $item)
          <tr data-product-id="{{ $id }}">
            <td>
              <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 50px; height: auto;">
              {{ $item['name'] }}
            </td>
            <td>${{ number_format($item['price'], 2) }}</td>
            <td>
              <input type="number" class="form-control quantity-input" value="{{ $item['quantity'] }}" min="1"
                style="width: 80px;">
            </td>
            <td class="item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
            <td>
              <button class="btn btn-sm btn-danger remove-item">Remove</button>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="text-end"><strong>Total:</strong></td>
          <td colspan="2" class="cart-total">${{ $total }}</td>
        </tr>
      </tfoot>
    </table>

    <div class="row">
      <div class="col-md-6">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
      </div>
      <div class="col-md-6 text-end">
        <!-- Checkout Form -->
        <form action="{{ route('checkout.process') }}" method="POST">
          @csrf
          <h5>Customer Information</h5>

          {{-- Display general validation errors if any --}}
          {{-- @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif --}}

          <div class="mb-3">
            <label for="customer_name" class="form-label">Name *</label>
            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name"
              value="{{ old('customer_name') }}" required>
            @error('customer_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="customer_email" class="form-label">Email *</label>
            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" name="customer_email"
              value="{{ old('customer_email') }}" required>
            @error('customer_email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="customer_phone" class="form-label">Phone *</label>
            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" name="customer_phone"
              value="{{ old('customer_phone') }}" required>
            @error('customer_phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Shipping Address *</label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2"
              required>{{ old('address') }}</textarea>
            @error('address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-success">Proceed to Checkout</button>
        </form>
      </div>
    </div>
  @endif
@endsection