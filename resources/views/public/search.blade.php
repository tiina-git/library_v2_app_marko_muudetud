@extends('layouts.app')
@section('title', 'Otsing')
@section('content')

<h2>Otsing</h2>
 {{-- Otsingu kast  --}}
    <form action="{{ route('search') }}" method="GET">
        <div class="input-group">
            <input type="text" name="query" placeholder="Sisesta otsing" value="{{ old('query') }}" required">
            <button class="btn btn-primary" type="submit">Otsi</button>
        </div>
        <div class="form-text"> min 3 tähemärki</div>
    </form>

@if(isset($books))
    @if($books->isEmpty())
        <p>Tulemusi ei leitud.</p>
    @else
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Pealkiri</th>
                        <th>Autor</th>
                        <th>Aasta</th>
                        <th>Lk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author?->name ?? '—' }}</td>
                            <td>{{ $book->published_year ?? '—' }}</td>
                            <td>{{ $book->pages ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif

@endsection