@extends('layouts.admin-master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Add new author</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Author create form</h6>
            </div>
            <div class="card-body">
                <form action="{{route('authors.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" class="form-control" name="slug">
                        @error('slug')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <input type="text" id="bio" class="form-control" name="bio">
                        @error('bio')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_url">Image</label>
                        <input type="file" id="image_url" class="form-control" name="image_url">
                        <small>Max size 500 KB</small>
                        @error('image_url')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Create" class="btn btn-primary">
                        <input type="reset" value="Reset" class="btn btn-danger">
                    </div>
                </form>
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
