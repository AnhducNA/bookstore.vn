@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="payment-area">
            <h4 class="my-4 bg-dark p-3 text-white">Make your payment</h4>
            @include('layouts.includes.flash-message')
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
                    @if(isset($shipping_address))
                    <input type="hidden" name="shipping_address" value="{{$shipping_address}}">
                    @endif
                    <input type="button" value="{{__('message.Payment by bank transfer')}}" id="btn-bankPayment" class="btn btn-outline-success btn-sm">
                    <input type="submit" name="btn-cashMethod" value="{{__('message.Cash on delivery')}}" id="btn-cashPayment" class="btn btn-outline-primary btn-sm">
                    <!-- Modal bank payment-->
                    <div class="modal fade" id="model-bankPayment" tabindex="-1" role="dialog"
                         aria-labelledby="Modal bank payment" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('message.Payment by bank transfer')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-capitalize text-dark">{{__('message.Please transfer money to your bank account number')}}</p>
                                    <div class="text-center">
                                        <strong class="text-success">1234567890</strong>
                                        <p class="text-primary">{{__('message.Vietnam Bank')}}</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('message.close')}}</button>
                                    <input type="submit" name="btn-bankMethod" class="btn btn-primary" value="{{__('OK')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            // Attach Button click event listener
            $("#btn-bankPayment").click(function () {
                // show Modal model-bankPayment
                $('#model-bankPayment').modal('show');
            });
        });
    </script>

@endsection
