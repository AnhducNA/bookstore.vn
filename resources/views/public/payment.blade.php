@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="payment-area">
            <h4 class="my-4 bg-dark p-3 text-white">Make your payment</h4>

            <div class="cart-summary my-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Order summary</h4>
                    </div>
                    <div class="card-body">
                        <p>Total products = {{$cart['total_quantity']}}</p>
                        <p>Product Cost = {{number_format($cart['total_price'], 0)}} VND</p>
                        <p>Shipping cost = {{number_format(25000, 0)}} VND</p>
                        <p><strong>Total cost = {{number_format($cart['total_price'] + 25000, 0)}} VND</strong></p>
                    </div>
                </div>
            </div>

            <div class="bg-light p-3 my-4">
                <form action="{{route('cart.checkout')}}" method="post">
                    @csrf
                    <input type="hidden" name="cart_total" value="{{$cart['total_price']}}">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_7xVvmxzKaoeFzuBZZ18WdwKy00bmfx80CA"
                            data-amount=""
                            data-name="Bookshop"
                            data-description="Bookstore payment"
                            data-locale="auto">
                    </script>
                </form>
            </div>
            <div class="bg-light p-3 my-4">
                <a class="btn btn-success btn-sm" href="{{url('/')}}"><strong>Cash on delivery</strong></a>
            </div>
        </div>
    </div>
@endsection
