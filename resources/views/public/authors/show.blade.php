@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <h1 class="mb-4">{{ $author->name }}</h1>

    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 200px;">Nimi</th>
                    <td>{{ $author->name }}</td>
                </tr>
                <tr>
                    <th>Loodud</th>
                    <td>{{ $author->created_at->format('d.m.Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Uuendatud</th>
                    <td>{{ $author->updated_at->format('d.m.Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if(!empty($author->bio))
        <div class="mb-4">
            <h2 class="h5">Biograafia</h2>
            <p>{{ $author->bio }}</p>
        </div>
    @endif

    <h2 class="h5 mb-3">Raamatud</h2>
    @if($author->books->count())
        <ul class="list-group mb-3">
            @foreach($author->books as $book)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
                    @if($book->published_year)
                        <small class="text-muted">{{ $book->published_year }}</small>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Sellel autoril pole raamatuid.</p>
    @endif

    <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary">
        Tagasi autorite nimekirja
    </a>
@endsection
