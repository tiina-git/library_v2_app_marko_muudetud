@extends('layouts.app')

@section('title', 'Autorid')

@section('content')
    <h1 class="mb-4">Autorid</h1>

    @if($authors->count())
        <ul class="list-group mb-3">
            @foreach($authors as $author)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('authors.show', $author) }}">
                        {{ $author->name }}
                    </a>
                    <span class="badge text-bg-secondary">{{ $author->books_count }} raamatut</span>
                </li>
            @endforeach
        </ul>

        {{ $authors->links() }}
    @else
        <p>Autoreid ei leitud.</p>
    @endif
@endsection
