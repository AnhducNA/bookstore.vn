@extends('layouts.admin-master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edit author</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span class="mr-3"><a href="{{route('authors.index')}}"><i class="fas fa-long-arrow-alt-left"></i> Back</a></span>
                <span class="m-0 font-weight-bold text-primary">Author edit form</span>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="display-img text-center p-4">
                        <img src="{{asset($author->image_url)}}" alt="">
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card-body">
                        <form action="{{route('authors.update', $author->id)}}" method="post" name="formUpdate">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{$author->name}}">
                                @error('name')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" class="form-control" name="slug" value="{{$author->slug}}">
                                @error('slug')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <input type="text" id="bio" class="form-control" name="bio" value="{{$author->bio}}">
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
                                <input type="submit" value="Update" class="btn btn-warning">
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
        const fileValueInput = "{{$author->image_url}}"
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
