@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <h1 class="mb-4">{{ $book->title }}</h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 200px;">Autor</th>
                    <td>
                        @if($book->author)
                            <a href="{{ route('authors.show', $book->author) }}">
                                {{ $book->author->name }}
                            </a>
                        @else
                            <em>Tundmatu autor</em>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Pealkiri</th>
                    <td>{{ $book->title }}</td>
                </tr>
                <tr>
                    <th>Ilmumisaasta</th>
                    <td>{{ $book->published_year ?? '-' }}</td>
                </tr>
                <tr>
                    <th>ISBN</th>
                    <td>
                        @if($book->isbn)
                            {{ $book->isbn }}
                            <br>
                            <a href="https://rahvaraamat.ee/et/s?searchQuery={{ $book->isbn }}" target="_blank" rel="noopener">
                                Otsi Rahva Raamatust
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Lehekülgi</th>
                    <td>{{ $book->pages ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Loodud</th>
                    <td>{{ $book->created_at->format('d.m.Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Uuendatud</th>
                    <td>{{ $book->updated_at->format('d.m.Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
        Tagasi raamatute nimekirja
    </a>
@endsection
