@extends('layouts.admin')
@section('content')
<div class="container">
    @include('partials.session_message')
    <div class="row">
        <div class="col-4">
            <h2 class="py-3">Add New Category</h2>
            <form class="d-flex align-items-center" action="{{route('admin.categories.store')}}" method="post">
                @csrf
                <div class="mr-3">
                    <label for="name" class="form-label mb-0">Name</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="helpIdName" placeholder="Insert Name">
                    <small id="helpIdName" class="form-text text-muted">Insert Name</small>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
        <div class="col-8">
            <h2 class="py-3">All Categories</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Number Post</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td scope="row" class="align-middle">{{$category->id}}</td>
                        <td class="align-middle">
                            <form id="form-categories-{{$category->id}}" action="{{route('admin.categories.update',$category->slug)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input class="border-0 bg-transparent" type="text" name="name" id="name" value="{{$category->name}}">
                            </form>
                        </td>
                        <td class="align-middle">{{$category->slug}}</td>
                        <td class="text-center align-middle">
                            <div class="bg-info badge p-2 text-white">
                                {{count($category->posts)}}
                            </div>
                        </td>
                        <td class="d-flex align-middle">
                            <button form="form-categories-{{$category->id}}" type="submit" class="btn btn-success mr-2">Update</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-category-{{$category->id}}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="delete-category-{{$category->id}}" tabindex="-1" aria-labelledby="modelTitle-{{$category->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Category "<span class="text-primary">{{$category->name}}</span>"</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                            <form action="{{route('admin.categories.destroy',$category->slug)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td scope="row">No Category</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection