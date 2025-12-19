@extends('layout')

@section('content')
<h3>Модерация комментариев</h3>

@if(session()->has('message'))
    <div class="alert alert-success my-3">{{ session('message') }}</div>
@endif

@if($comments->count())
<ul class="list-group">
    @foreach($comments as $comment)
    <li class="list-group-item">
        <div class="d-flex justify-content-between">
            <div>
                <strong>Статья:</strong>
                <a href="{{ route('article.show', $comment->article->id) }}">
                    {{ $comment->article->title }}
                </a>
                <div class="mt-2"><strong>Комментарий:</strong> {{ $comment->text }}</div>
                <div class="mt-1 text-muted"><small>От: {{ $comment->user?->name ?? 'Гость' }}</small></div>
            </div>

            <div class="d-flex align-items-center">
                <form action="{{ route('comments.accept', $comment) }}" method="POST" class="me-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-success">Принять</button>
                </form>

                <form action="{{ route('comments.reject', $comment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Отклонить</button>
                </form>
            </div>
        </div>
    </li>
    @endforeach
</ul>

<div class="mt-3">
    {{ $comments->links() }}
</div>
@else
    <div class="alert alert-info">Нет новых комментариев для модерации.</div>
@endif
@endsection
