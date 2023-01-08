@extends('layouts.admin-master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edit category</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span class="mr-3"><a href="{{route('categories.index')}}">
                        <i class="fas fa-long-arrow-alt-left"></i> Back</a>
                </span>
                <span class="m-0 font-weight-bold text-primary">Category edit form</span>
            </div>
            <div class="card-body">
                <form action="{{route('categories.update', $category->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{$category->name}}">
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" class="form-control" name="slug" value="{{$category->slug}}">
                        @error('slug')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update" class="btn btn-warning">
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
