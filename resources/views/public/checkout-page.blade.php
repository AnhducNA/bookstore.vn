@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="my-4 p-3 bg-dark text-white"><h4 class="m-0">Checkout Page</h4></div>
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-product">
                    <h4><a href="{{route('cart.page')}}" title="Back to cart" class="text-danger"><i class="fas fa-shopping-basket" ></i></a> Your orders</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Book</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Sub Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0 ?>
                        @foreach($cart['products'] as $item)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['quantity']}}</td>
                            <td>{{number_format($item['price'], 0)}} VND</td>
                            <td>{{number_format($item['sub_total'], 0)}} VND</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="billing-address my-4">
                    <div class="p-3 bg-light my-4"><h4 class="m-0">Billing address</h4></div>

                    <form action="{{route('cart.proceed')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="shipping_name" required class="form-control" value="{{Auth::user()? Auth::user()->name : ''}}" placeholder="Name">

                            @if($errors->has('shipping_name'))
                                <span class="invalid-feedback"><strong>{{$errors->first('shipping_name')}}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="text" name="mobile_no" required class="form-control" placeholder="Mobile number">

                            @if($errors->has('mobile_no'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('mobile_no')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <textarea name="address" required class="form-control" placeholder="Shipping Address" cols="30" rows="5"></textarea>
                            @if($errors->has('address'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('address')}}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="payment-area my-4 py-5 px-3 bg-light">
                            <input type="submit" value="Proceed to payment" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary my-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order summary</h4>
                        </div>
                        <div class="card-body">
                            <p>Total products = {{$cart['total_quantity']}}</p>
                            <p>Product Cost = {{number_format($cart['total_price'], 0)}} VND</p>
                            <p>Shipping cost = {{number_format(0, 0)}} VND</p>
                            <p><strong>Total cost = {{number_format($cart['total_price'] + 0, 0)}} VND</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
