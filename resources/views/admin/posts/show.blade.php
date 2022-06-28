@extends('layouts.admin')
@section('content')
<div class="container">
    <h1 class="text-center py-5">Preview "{{$post->title}}"</h1>
    @include('partials.session_message')
    <div class="card mx-auto">
        <div class="row">
            <div class="col">
                <img class="w-100 h-100" src="{{$post->image}}" alt="{{$post->title}}">
            </div>
            <div class="col">
                <div class="card-body">
                    <h2>{{$post->title}}</h2>
                    <p>{{$post->body}}</p>
                    <div class="metadata">
                        <div class="category">
                            <strong>Category: </strong>{{$post->category ? $post->category->name : 'No Category'}}
                        </div>
                        <div class="tags">
                            <strong>Tags:</strong>
                            @if (count($post->tags) > 0)
                            @foreach($post->tags as $tag)
                            #{{$tag->name}}
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <a class="btn btn-primary mt-3" href="{{route('admin.posts.index')}}" role="button">Back To Dashboard</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection