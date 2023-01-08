@extends('layouts.admin-master')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edit book</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span class="mr-3"><a href="{{route('books.index')}}"><i
                            class="fas fa-long-arrow-alt-left"></i> Back</a></span>
                <span class="m-0 font-weight-bold text-primary">Book edit form</span>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="display-img text-center p-4">
                        <img src="{{asset('assets/img/default_user.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card-body">
                        <form method="post" name="formUpdate" action="{{route('books.update', $book->id) }}">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{$book->title ? $book->title : ''}}">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control"
                                       value="{{$book->slug ? $book->slug : ''}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10"
                                          class="form-control">{{$book->description ? $book->description : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="author_id">Author</label>
                                <select name="author_id" id="author_id" class="form-control">
                                    <option value="{{$book->author_id}}">{{$book->author_name}}</option>
                                    @foreach ($authors as $author)
                                        <option value="{{$author->id}}">{{$author->id. ' - '.$author->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="{{$book->category_id}}">{{$book->category_name}}</option>
                                    @foreach ($categories as $category)
                                        <option
                                            value="{{$category->id}}">{{$category->id.' - '.$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="init_price">Regular Price</label>
                                <input type="text" name="init_price" id="init_price" class="form-control"
                                       value="{{$book->init_price}}">
                            </div>
                            <input type="hidden" name="price" value="{{$book->price}}">
                            <div class="form-group">
                                <label for="discount_rate">Discount Rate</label>
                                <input type="text" name="discount_rate" id="discount_rate" class="form-control"
                                       value="{{$book->discount_rate}}">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" id="quantity" class="form-control"
                                       value="{{$book->quantity}}">
                            </div>
                            <input type="hidden" name="image_id" value="{{$book->image_id}}">
                            <div class="form-group">
                                <label for="image_url">Book Image</label>
                                <input type="file" name="image_url" id="image_url" class="form-control"
                                       value="{{$book->image_url}}">
                                <small>Max size 1MB</small>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="btn-update" value="Update" class="btn btn-warning">
                                <input type="reset" value="Reset" class="btn btn-danger">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        /*
        set value for input[type='file']
         */
        const fileValueInput = "{{$book->image_url}}"
        // Get a reference to file input
        const fileInput = document.forms['formUpdate']['image_url'];
        // Create a new File object
        const myFile = new File(['Hello World!'], fileValueInput, {
            type: 'text/plain',
            lastModified: new Date(),
        });
        // Now let's create a DataTransfer to get a FileList
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(myFile);
        fileInput.files = dataTransfer.files;
        // console.log(fileInput.files);

        /*
         making slug automatically
        */
        $('#name').on('blur', function () {
            var theTitle = this.value.toLowerCase().trim(),
                slugInput = $('#slug');
            theSlug = theTitle.replace(/&/g, '-and-')
                .replace(/[^a-z$0-9-]+/g, '-')
                .replace(/\-\-+/g, '-')
                .replace(/^-+|-+$/g, '')

            slugInput.val(theSlug);
        });
    </script>
@endsection
