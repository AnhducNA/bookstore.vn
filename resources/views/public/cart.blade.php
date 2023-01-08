@extends('layouts.master')
@section('title')
    Bookshop - Cart page
@endsection

@section('content')
    <div class="container">
        <div class="card my-4">
            <div class="card-header bg-dark text-white">
                <h4><i class="fas fa-shopping-cart"></i> Shopping cart</h4>
            </div>
            <div class="card-body">
                @include('layouts.includes.flash-message')
                @if(!empty($cart) && count($cart['products'])>=1)
                    <table class="table table-borderless" id="info-cart-wp">
                        <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Price</th>
                            <th scope="col" width="100">Quantity</th>
                            <th scope="col">Sub total</th>
                        </tr>
                        </thead>
                        @foreach($cart['products'] as $item)
                            <tbody>
                            <tr class="border-bottom">
                                <td><a href="{{route('cart.delete' ,['id' => $item['id']])}}" class="text-danger"
                                       title="Remove cart item"><i class="fas fa-times"></i></a></td>

                                <td><img src="{{asset($item['image_file'])}}" alt="" width="50"></td>

                                <td>{{$item['name']}}</td>

                                <td>{{number_format($item['price'], 0)}} VND</td>

                                <td>
                                    <span class="quantity-input mr-2 mb-2 d-flex flex-row">
                                        <a href="{{route('cart.decrement', ['id' => $item['id'], 'qty' => $item['quantity']])}}"
                                           class="cart-minus">-</a>
                                        <input title="QTY" name="quantity" type="number" data-id="{{$item['id']}}" value="{{$item['quantity']}}"
                                               class="qty-text">
                                        <a href="{{route('cart.increment', ['id' => $item['id'], 'qty' => $item['quantity']])}}"
                                           class="cart-plus">+</a>
                                    </span>
                                </td>

                                <td>{{number_format($item['sub_total'])}} VND</td>
                            </tr>
                            </tbody>
                        @endforeach
                        <tbody>
                        <tr>
                            <td colspan="4"><a href="{{route('all-books')}}" class="text-primary">Continue shopping</a>
                            </td>
                            <td><strong>Total</strong></td>
                            <td>{{number_format($cart['total_price'])}} VND</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <a href="{{route('cart.deleteAll')}}" class="btn btn-outline-danger">Delete All</a>
                            </td>
                            <td colspan="1">
                                <a href="{{route('cart.update')}}" onclick="changeAllListCart()"
                                   class="btn btn-outline-warning btn-sm">Update</a>
                            </td>
                            <td colspan="2">
                                <a href="{{route('checkout')}}" class="btn btn-outline-primary btn-sm">Checkout
                                    <i class="fas fa-long-arrow-alt-right"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning">No item found in cart. <a href="{{route('all-books')}}"> Continue
                            shopping</a></div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function changeAllListCart() {
            var $list = [];
            $('#info-cart-wp tr td').each(function () {
                $(this).find('input').each(function () {
                    var element = {
                        key: $(this).attr('data-id'),
                        value: $(this).val()
                    };
                    $list.push(element);
                });
            });
            $.ajax({
                url: '../cart/update',
                type: 'POST',
                data: {
                    '_token': "{{csrf_token()}}",
                    'data': $list,
                }
            }).done(function () {
                location.reload();
                alertify.success('Đã cập nhật tất cả sản phẩm');
            });
        }


    </script>
@endsection
