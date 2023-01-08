@extends('layouts.admin-master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Authors</h1>
        <div class="my-2 px-1">
            <div class="row">
                <div class="col-6">
                    <div>
                        <a href="{{route('authors.create')}}" class="btn-primary btn-sm">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Add Authors
                        </a>
                    </div>
                </div>
                <div class="col-6 text-right">
                    <span class="mr-2"><a href="#">Discount books</a> |</span>
                    <span class="mr-2"><a href="#">Trash books</a></span>
                </div>
            </div>
        </div>

        @include('layouts.includes.flash-message')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Authors list</h6>
            </div>
            <div class="card-body">
                @if($authors->count())
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Books Count</th>
                                <th>Bio</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Action</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Books Count</th>
                                <th>Bio</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($authors as $author)
                                <tr>
                                    <td>
                                        <form action="{{route('authors.destroy',  $author->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{route('authors.edit', $author->id)}}"
                                               class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                            <button type="submit"
                                                    onclick="return confirm('Category will delete permanently. All books related with this category will deleted. Are you sure to delete??')"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td><img src="{{asset($author->image_url)}}"
                                            height="50" alt=""></td>
                                    <td><a href="{{route('authors.edit', $author->id)}}">{{$author->name}}</a></td>
                                    <td>{{$author->countBook}}</td>
                                    <td>{{Str::limit($author->bio, 40)}} <a href="#">read more</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
