@php use Carbon\Carbon;use GrahamCampbell\Markdown\Facades\Markdown; @endphp
@extends('layouts.master');
@section('title')
    Bookshop - Book details
@endsection
@section('content')
    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="content-area">
                        <div class="card my-4">
                            <div class="card-header bg-dark">
                                <h4 class="text-white">{{__('message.book-detail')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-4">
                                        <div class="book-img-details">
                                            <img src="{{asset($book->image_url)}}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="book-title">
                                            <h5>{{$book->title}}</h5>
                                        </div>
                                        <div class="author mb-2">
                                            By <a href="">{{$book->author_name}}</a>
                                        </div>
                                        @if(($book->quantity) > 1)
                                            <div class="badge badge-success mb-2">{{__('message.in-shock')}}</div>
                                        @else
                                            <div class="badge badge-danger mb-2">{{('message.out-of-shock')}}</div>
                                        @endif
                                        @if($book->discount_rate)
                                            <h6><span
                                                    class="badge badge-warning">{{__('message.discount')}} {{$book->discount_rate}}% </span>
                                            </h6>
                                        @endif
                                        <div class="book-price mb-2">
                                            <span class="mr-1">{{__('message.price')}}</span>
                                            @if($book->discount_rate)
                                                <strong class="line-through">{{number_format($book->init_price, 0)}}
                                                    VND</strong>
                                            @endif
                                            <span>{{__('message.now')}}</span>
                                            <strong> {{number_format($book->price, 0)}} VND</strong>
                                            @if($book->discount_rate)
                                                <div><strong class="text-danger">{{__('message.product.save')}}
                                                        {{number_format($book->init_price - $book->price)}} VND
                                                    </strong></div>
                                            @endif
                                        </div>
                                        <div class="book-category mb-2 py-1 d-flex flex-row border-top border-bottom">
                                            <a href="{{route('category', $book->category_slug)}}" class="mr-4"><i
                                                    class="fas fa-folder"></i>
                                                {{__("message.product.categories.name.$book->category_name")}}
                                            </a>
                                            <a href="#review-section" class="mr-4"><i class="fas fa-comments"></i>
                                                {{__('message.reviews')}}
                                            </a>
                                        </div>
                                        <form action="{{route('cart.store')}}" method="post">
                                            @csrf
                                            <div class="cart">
                                            <span class="quantity-input mr-2 mb-2">
                                                <a href="#" class="cart-minus" id="cart-minus">-</a>
                                                <input title="QTY" name="quantity" type="number" min="1" value="1"
                                                       class="qty-text">
                                                <a href="#" class="cart-plus" id="cart-plus">+</a>
                                            </span>
                                                <input type="hidden" name="book_id" value="{{$book->id}}">
                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-shopping-cart"></i> {{__('message.Add to cart')}}
                                                </button>
                                            </div>
                                        </form>
                                        @include('layouts.includes.flash-message')
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="book-description p-3">
                                        <p>{!! Markdown::convertToHtml($book->description) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-body my-4">
                            <div class="author-description d-flex flex-row">
                                <div class="author-img mr-4">
                                    <img src="{{asset('assets/img/default_user.png')}}" alt="">
                                </div>
                                <div class="des">
                                    <h5><a href="{{route('author', $book->author_slug)}}">{{$book->author_name}}</a>
                                    </h5>
                                    <small>
                                        <a href="{{route('author', $book->author_slug)}}">
                                            <i class="fas fa-book"></i>
                                            {{-- {{$book->author->books()->count()}}--}}
                                            {{-- {{str_plural('Book', $book->author->books()->count())}}--}}
                                        </a>
                                    </small>
                                    <p>{!! Markdown::convertToHtml(e($book->author_bio)) !!}</p>
                                </div>
                            </div>
                        </div>
                        <!-- COMMENTS HERE -->
                        <div class="comments-section">
                            <div class="card card-body my-4" id="review-section">
                                <div class="comments-area">
                                    {{--            <h4 class="text-center mb-2"><i class="fas fa-comments"></i> {{$book_reviews->count()}} {{str_plural('Review', $book_reviews->count()) }}</h4>--}}
                                    @foreach($book_reviews as $review)
                                        <div class="single-comment my-2">
                                            <div class="card card-body bg-light">
                                                <div class="author-info mb-2 d-flex flex-row">
                                                    <div class="comment-user-img mr-3">
                                                        <img src="{{asset('assets/img/default_user.png')}}" alt=""
                                                             width="60">
                                                    </div>
                                                    <div>
                                                        <h5>{{$review->user_name}}</h5>
                                                        <small><i
                                                                class="fas fa-clock"></i> {{Carbon::parse($review->created_at)->diffForHumans('', true).'ago'}}
                                                        </small>
                                                    </div>
                                                </div>
                                                <p>{!! Markdown::convertToHtml(e($review->body)) !!}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card card-body my-4">
                                @if(Auth::check())
                                    <div class="comment-form">
                                        <h4 class="text-center">Leave a review</h4>
                                        <form action="{{route('book.review', $book->id)}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <textarea id="" name="body" rows="5"
                                                          class="form-control {{$errors->has('body')? 'is-invalid': ''}}"></textarea>
                                                @error('body')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary">Review</button>
                                        </form>
                                    </div>

                                @else
                                    <div><a href="{{url('login')}}">Login here</a> For leave a review.</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Sidebar -->
                @include('layouts.includes.side-bar')
                <!-- Sidebar end -->
            </div>
        </div>
    </section>
@endsection
