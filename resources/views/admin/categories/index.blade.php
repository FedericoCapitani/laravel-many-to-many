@extends('layouts.admin')


@section('content')




@include('partials.session_message')
@include('partials.errors')

<div class="container">
    <h1 class="my-3">All Categories</h1>
    <div class="row">
        <div class="col pe-5">
            <form action="" method="post" class="d-flex align-items-center">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Add</button>
                </div>
            </form>
        </div>
        <div class="col">

            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cats as $category)
                    <tr>
                        <td scope="row">{{$category->id}}</td>
                        <td>
                            <form id="category-{{$category->id}}" action="{{route('admin.categories.update', $category->slug)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input class="border-0 bg-transparent" type="text" name="name" value="{{$category->name}}">
                            </form>

                        </td>
                        <td>{{$category->slug}}</td>
                        <td><span class="badge badge-info bg-light">{{count($category->posts)}}</span></td>
                        <td>
                            <button form="category-{{$category->id}}" type="submit" class="btn btn-primary">Update</button>

                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-category-{{$category->id}}">
                                Delete
                            </button>
                            <div class="modal fade" id="delete-category-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitle-{{$category->id}}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete current</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this category?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                                            <form action="{{route('admin.posts.destroy', $category->slug)}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">Confirm</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td scope="row">No categories! Add your first category.</td>

                    </tr>
                    @endforelse
                </tbody>
            </table>


        </div>

    </div>
</div>


@endsection

<!-- <form action="{{route('admin.categories.destroy', $category->slug)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-white">Delete</button>
                            </form> -->