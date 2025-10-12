@extends('layouts.app')

@section('title', 'Raamatud (admin)')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Raamatud</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Lisa raamat</a>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if($books->count())
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>Pealkiri</th>
            <th>Autor</th>
            <th>Aasta</th>
            <th>ISBN</th>
            <th>Lehti</th>
            <th class="text-end">Tegevused</th>
          </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
          <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author?->name }}</td>
            <td>{{ $book->published_year ?? '—' }}</td>
            <td>{{ $book->isbn ?? '—' }}</td>
            <td>{{ $book->pages ?? '—' }}</td>
            <td class="text-end">
              <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-secondary">Muuda</a>
              <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Kustutan kindlasti?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Kustuta</button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    {{ $books->links() }}
  @else
    <div class="alert alert-info mb-0">Raamatud puuduvad. Lisa esimene raamat.</div>
  @endif
</div>
@endsection
