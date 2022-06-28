@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome back <span class="text-primary">{{Auth::user()->name}}</span></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <div class="button mt-3">
                        <a class="btn btn-primary" href="{{route('admin.posts.index')}}" role="button">Go to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection