@extends('layout')

@section('content')

@if(session()->has('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
@endif

<div class="card mb-4" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title text-center">{{ $article->title }}</h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $article->date_public }}</h6>
        <p class="card-text">{{ $article->text }}</p>

        <div class="btn-toolbar mt-3" role="toolbar">
            <a href="/article/{{ $article->id }}/edit" class="btn btn-primary me-3">Edit article</a>
            <form action="/article/{{ $article->id }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger me-3">Delete article</button>
            </form>
        </div>
    </div>
</div>

<h4>Comments</h4>

<ul class="list-group mb-4">
    @forelse ($article->comments as $comment)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $comment->text }}
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ms-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </li>
    @empty
        <li class="list-group-item">No comments yet.</li>
    @endforelse
</ul>

<h5>Add a Comment</h5>
<form action="{{ route('comments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="article_id" value="{{ $article->id }}">
    <div class="mb-3">
        <textarea name="text" class="form-control" placeholder="Write your comment..." rows="3">{{ old('text') }}</textarea>
        @error('text')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-success">Add Comment</button>
</form>

@endsection
