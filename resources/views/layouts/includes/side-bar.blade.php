@php use Carbon\Carbon; @endphp
<div class="col-md-4">
    <div class="sidebar-items">
        <div class="card my-4">
            <div class="card-header bg-dark text-white">
                <h4>{{__('message.product-category')}}</h4>
            </div>
            <div class="card-body">
                <ul class="ctg-list">
                    @if(!empty($categories))
                        @foreach($categories as $category)
                            <li class="ctg-item">
                                <a href="{{route('category', $category->slug)}}"
                                   class="ctg-link d-block">{{__("message.product.categories.name.$category->name")}}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="card my-3">
            <div class="card-header bg-dark text-white">
                <h4>{{__('message.new-book')}}</h4>
            </div>
            <div class="card-body">
                @if(!empty($recent_books))
                    @foreach($recent_books as $book)
                        <div class="recent-book-list">
                            <a href="{{(route('book-details', $book->slug))}}" class="d-flex flex-row mb-3">
                                <div class="book-img mr-2"><img src="{{asset($book->image_url)}}" alt="" width="80"></div>
                                <div class="book-text">
                                    <p>{{$book->title}}</p>
                                    <small><i class="fas fa-clock"></i>
                                        {{$date = Carbon::parse($book->created_at)->diffForHumans('', true).' ago'}}
                                    </small>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
