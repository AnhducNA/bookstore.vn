@extends('layouts.master')
@section('title')
    Bookshop - All books
@endsection

@section('content')
    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="content-area">
                        @if($term=request()->input('term'))
                            <div class="alert alert-info my-3">
                                Search result for <strong>{{$term}}</strong>
                            </div>
                        @endif
                        @if(!($books->count()))
                            <div class="alert alert-warning my-4">{{__('No books available')}}</div>
                        @else
                            <div class="card my-4">
                                <div class="card-header bg-dark">
                                    <h4 class="text-white">{{__('message.all-book')}}</h4>
                                </div>
                                @if(!empty($categoryName))
                                    <div class="alert alert-info m-3">
                                        {{__('message.book')}} <strong> {{__("message.product.categories.name.$categoryName")}}</strong>
                                    </div>
                                @endif
                                @if(isset($authorName))
                                    <div class="alert alert-info m-3">
                                        Writer <strong>{{$authorName}}</strong>
                                    </div>
                                @endif
                                @if(isset($discountTitle))
                                    <div class="alert alert-info m-3">
                                        <strong>{{$discountTitle}}</strong>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($books as $book)
                                            <div class="col-lg-3 col-6">
                                                <div class="book-wrap text-center">
                                                    <div class="book-image mb-2">
                                                        <a href="{{route('book-details', $book->slug)}}"><img src="<?php echo asset($book->image_url)?>" alt=""></a>
                                                        @if($book->discount_rate)
                                                            <h6><span class="badge badge-warning discount-tag">{{__('message.discount')}} {{$book->discount_rate}}%</span>
                                                            </h6>
                                                        @endif
                                                    </div>
                                                    <div class="book-title mb-2">
                                                        <a href="{{route('book-details', $book->slug)}}">{{$book->title}}</a>
                                                    </div>
                                                    <div class="book-author mb-2">
                                                        <small>By <a href="">{{$book->author_name}}</a></small>
                                                    </div>
                                                    <div class="book-price mb-3">
                                                        @if($book->discount_rate)
                                                            <span class="line-through mr-3">{{number_format($book->init_price)}} VND</span>
                                                        @endif
                                                        <span class=""><strong>{{number_format($book->price)}} VND</strong></span>
                                                    </div>
                                                    <div class="book-add-to-cart mb-3">
                                                        <button type="button" class="btn btn-secondary">{{__('message.Add to cart')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="show-more pt-2 text-right">
                                        <nav class="text-center">
                                            {{ $books->links() }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Sidebar -->
                @include('layouts.includes.side-bar')
                <!-- Sidebar end -->
            </div>
        </div>
    </section>
@endsection
