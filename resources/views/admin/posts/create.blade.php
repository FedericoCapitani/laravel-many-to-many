@extends('layouts.admin')
@section('content')
<div class="container">
    @include('partials.errors')
    <form class="bg-light mt-5 p-3" action="{{route('admin.posts.store')}}" method="post">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Insert Title" aria-describedby="helpTitle" value="{{old('title')}}">
            @include('partials.single_errors',['variable' => 'title'])
        </div>


        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" name="image" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="Insert image" aria-describedby="helpimage" value="{{old('image')}}">
            @include('partials.single_errors',['variable' => 'image'])
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" name="category_id" id="category_id">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
            </select>
            @include('partials.single_errors',['variable' => 'category_id'])
        </div>

        <div class="mb-3">
          <label for="tag_id" class="form-label">Tags</label>
          <select multiple class="custom-select" name="tags[]" id="tag_id" aria-label="Tag">
            <option value="" disabled>Select a Tags</option>
            @forelse($tags as $tag)
            @if($errors->any())
            <option value="{{$tag->id}}" {{in_array($tag->id,old('tags',[])) ? 'selected' : ''}}>{{$tag->name}}</option>
            @else
            <option value="{{$tag->id}}">{{$tag->name}}</option>
            @endif
            @empty
            <option>No Tags</option>
            @endforelse
          </select>
          @include('partials.single_errors',['variable' => 'tag_id'])
        </div>


        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea type="text" name="body" id="body" class="form-control @error('body') is-invalid @enderror" placeholder="body" rows="5" aria-describedby="bodyHelper">{{old('body')}}</textarea>
            @include('partials.single_errors',['variable' => 'body'])
        </div>

        <button type="submit" class="btn btn-primary">Add new Post</button>
    </form>
</div>
@endsection