@extends('layouts.app')

@section('title', 'Raamatud')

@section('content')
    <h1 class="mb-4">Raamatud</h1>

    @if($books->count())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($books as $book)
                <div class="col">
                    <div class="card h-100 shadow-sm position-relative">
                        <div class="card-body">
                            <h2 class="h6 card-title mb-1">{{ $book->title }}</h2>
                            <p class="card-text text-muted mb-0">
                                {{ $book->author?->name ?? 'Tundmatu autor' }}
                                @if($book->year)
                                    · {{ $book->year }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('books.show', $book) }}" class="stretched-link"
                           aria-label="Vaata: {{ $book->title }}"></a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-end">
            {{ $books->links() }}
        </div>
    @else
        <p>Raamatuid ei leitud.</p>
    @endif
@endsection
