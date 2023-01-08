<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Bookshop - Home')</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('/assets/img/favicon.png')}}" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/css/all.min.css')}}">
    <!-- Bootstrap core CSS -->
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
</head>
<body>
<!-- NAVBAR -->
@include('layouts.includes.navbar')
<!-- NAVBAR END -->
<!-- HEADER -->
<section class="header py-2 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="headings">
                    <h3><a href="{{route('bookshop.home')}}" class="text-secondary"><b class="text-danger">Book</b> Shop</a>
                    </h3>
                </div>
            </div>
            <div class="col-md-4">
                <form action="{{route('all-books')}}">
                    <div class="input-group input-group-sm m-1">
                        <input type="text" name="term" value="{{request('term')}}" class="form-control"
                               placeholder="Search Book..">
                        <div class="input-group-append">
                            <button class="btn btn-danger" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="shopping-cart text-right">
                    <a href="{{route('cart.page')}}" class="text-danger"><i class="fas fa-shopping-cart fa-2x m-1"></i>
                        <span class="count-cart">
                            @if(!empty(session('cart')['total_quantity']))
                                {{session('cart')['total_quantity']}}
                            @else
                                0
                            @endif
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- HEADER END -->
@yield('content')
@include('layouts.includes.footer')

<!-- Font Awesome -->
<script type="text/javascript" src="{{asset('/assets/js/all.min.js')}}"></script>
<!-- jQuery -->
<script type="text/javascript" src="{{asset('/assets/js/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="{{asset('/assets/js/popper.min.js')}}"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
<!-- Your custom scripts (optional) -->
<script type="text/javascript" src="{{asset('/assets/js/script.js')}}"></script>
@yield('script')
</body>
</html>
