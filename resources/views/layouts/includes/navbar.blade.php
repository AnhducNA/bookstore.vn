@php use Illuminate\Support\Facades\Auth; @endphp
<nav class="navbar navbar-expand-sm text-white navbar-white p-1 border-bottom" id="nav-top">
    <div class="container">
        <a href="{{route('bookshop.home')}}" class="logo-img"></a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-collapse">
            <ul class="navbar-nav">
                <li class="nav-item px-2 ">
                    <a href="{{route('bookshop.home')}}" class="nav-link">{{__('message.home')}}</a>
                </li>
                <li class="nav-item px-2">
                    <a href="{{route('all-books')}}" class="nav-link">{{__('message.books')}}</a>
                </li>
                <li class="nav-item px-2">
                    <a href="{{route('discount-books')}}" class="nav-link">{{__('message.discount_book')}}</a>
                </li>
                <li class="nav-item px-2">
                    <a href="#" class="nav-link">{{__('message.about')}}</a>
                </li>
                @if(Auth::check())
                    <li class="nav-item px-2">
                        <a href="#" class="nav-link">{{__('message.track_orders')}}</a>
                    </li>
                @endif

            </ul>
            <ul class="navbar-nav ml-auto">
                @php $locale = session()->get('locale'); @endphp
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @switch($locale)
                            @case('en')
                                <img src="{{asset('assets/img/flag/en.png')}}" width="25px"> English
                                @break
                            @case('vi')
                                <img src="{{asset('assets/img/flag/vi.png')}}" width="25px"> Việt Nam
                                @break
                            @default
                                <img src="{{asset('assets/img/flag/en.png')}}" width="25px"> English
                        @endswitch
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{url('change-language/en')}}"><img
                                src="{{asset('assets/img/flag/en.png')}}" width="25px"> English</a>
                        <a class="dropdown-item" href="{{url('change-language/vi')}}"><img
                                src="{{asset('assets/img/flag/vi.png')}}" width="25px"> Việt Nam</a>
                    </div>
                </li>
                @if(Auth::check() == false)
                    <li class="nav-item px-2">
                        <a href="{{url('login')}}" class="nav-link text-danger">
                            <i class="fas fa-user-lock"></i>
                            {{__('message.login')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('register')}}" class="nav-link">
                            <i class="fas fa-user"></i>
                            {{__('message.register')}}
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" data-toggle="dropdown">
                            <span class="image-circle">
                                <img src="{{asset('assets/img/default_user.png')}}" width="30" alt="">
                            </span>
                            {{Auth::user()->name}}

                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-muted"></i>
                                Profile
                            </a>
                            {{--                            @if(Auth::user()->role->name == "Admin")--}}
                            {{--                                <a class="dropdown-item" href="{{route('admin.home')}}">--}}
                            {{--                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-muted"></i>--}}
                            {{--                                    Profile--}}
                            {{--                                </a>--}}
                            {{--                            @elseif(Auth::user()->role->name == "User")--}}
                            {{--                                <a class="dropdown-item" href="{{route('user.home')}}">--}}
                            {{--                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-muted"></i>--}}
                            {{--                                    Profile--}}
                            {{--                                </a>--}}
                            {{--                            @else--}}
                            {{--                                <a class="dropdown-item" href="#">--}}
                            {{--                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-muted"></i>--}}
                            {{--                                    Profile--}}
                            {{--                                </a>--}}
                            {{--                            @endif--}}
                            <a class="dropdown-item" href="{{url('logout')}}">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-muted"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
