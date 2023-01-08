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
                        <form method="post" name="formCreate" action="{{ route('books.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10"
                                          class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="author_name">Author name</label>
                                <input type="text" name="author_name" id="author_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="author_slug">Author slug</label>
                                <input type="text" name="author_slug" id="author_slug" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="author_bio">Author bio</label>
                                <textarea name="author_bio" id="author_bio" cols="30" rows="10"
                                          class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->id.' - '.$category->name}}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="init_price">Regular Price</label>
                                <input type="text" name="init_price" id="init_price" class="form-control">
                            </div>
                            <input type="hidden" name="price">
                            <div class="form-group">
                                <label for="discount_rate">Discount Rate</label>
                                <input type="text" name="discount_rate" id="discount_rate" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                            </div>
                            <input type="hidden" name="image_id" value="">
                            <div class="form-group">
                                <label for="image_url">Book Image</label>
                                <input type="file" name="image_url" id="image_url" class="form-control">
                                <small>Max size 1MB</small>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="btn-update" value="Create" class="btn btn-primary">
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
