@extends('layouts.admin')
@section('content')
<div class="container">
    <h1>Edit "{{$post->title}}</h1>
    @include('partials.errors')
    <form class="mt-5 text-center " action="{{ route('admin.posts.update', $post->slug )}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Insert Title" aria-describedby="helpTitle" value="{{$post->title}}">
                @include('partials.single_errors',['variable' => 'title'])
            </div>
        </div>
        <div class="form-group">
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input class="py-2 px-3 w-100 form-control @error('cover_image') is-invalid @enderror" type="file" id="cover_image" name="cover_image" placeholder="inserisci l'url del cover_image della copertina" value="" required>
                @include('partials.single_errors',['variable' => 'image'])
            </div>
        </div>
        <div class="mb-3">
          <label for="category_id" class="form-label">Category</label>
          <select class="form-control" name="category_id" id="category_id">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}" {{$post->category_id == old('category_id', $category->id) ? 'selected' : ''}} >{{$category->name}}</option>
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
            <option value="{{$tag->id}}" {{in_array($tag->id,old('tags')) ? 'selected' : ''}}>{{$tag->name}}</option>
            @else
            <option value="{{$tag->id}}" {{$post->tags->contains($tag->id) ? 'selected' : ''}}>{{$tag->name}}</option>
            @endif
            @empty
            <option>No Tags</option>
            @endforelse
          </select>
          @include('partials.single_errors',['variable' => 'tag_id'])
        </div>
        <div class="form-group">
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea type="text" name="body" id="body" class="form-control @error('body') is-invalid @enderror" placeholder="body" rows="5" aria-describedby="bodyHelper">{{$post->body}}</textarea>
                @include('partials.single_errors',['variable' => 'body'])
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Edit Post</button>
    </form>
</div>
@endsection