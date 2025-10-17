
@extends('layouts.app')

@section('title', 'Raamatud')

@section('content')
<div class="container my-4">
    <h1 class="mb-4">Raamatute nimekiri</h1>

    @if($books->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th style="cursor: pointer;">
                            {{-- Title sort link: toggle direction when current sort is title --}}
                            @php($newDir = ($sort === 'title' && $direction === 'asc') ? 'desc' : 'asc')
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => $newDir]) }}">
                                Pealkiri
                                @if($sort === 'title')
                                    <small class="text-muted">({{ strtoupper($direction) }})</small>
                                @endif
                            </a>
                        </th>
                        <th style="width: 300px; cursor: pointer;">
                            {{-- Author sort link --}}
                            @php($newDirAuthor = ($sort === 'author' && $direction === 'asc') ? 'desc' : 'asc')
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'author', 'direction' => $newDirAuthor]) }}">
                                Autor
                                @if($sort === 'author')
                                    <small class="text-muted">({{ strtoupper($direction) }})</small>
                                @endif
                            </a>
                        </th>
                        <th style="width:120px;">Aasta</th>
                        <th style="width:140px;">ISBN</th>
                        <th style="width:120px;">Lk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>
                                <a href="{{ route('books.show', $book) }}">
                                    {{ $book->title }}
                                </a>
                            </td>
                            <td>
                                {{ $book->author?->name ?? 'Tundmatu autor' }}
                            </td>
                            <td>{{ $book->published_year ?? '-' }}</td>
                            <td>{{ $book->isbn ?? '-' }}</td>
                            <td>{{ $book->pages ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $books->links() }}
        </div>
    @else
        <p>Raamatuid ei leitud.</p>
    @endif
</div>
@endsection