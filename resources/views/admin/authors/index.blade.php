@extends('layouts.app')

@section('title', 'Autorid (admin)')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Autorid</h1>
    <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">Lisa autor</a>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if($authors->count())
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>Nimi</th>
            <th>Bio</th>
            <th class="text-end">Tegevused</th>
          </tr>
        </thead>
        <tbody>
        @foreach($authors as $author)
          <tr>
            <td>{{ $author->name }}</td>
            <td class="small text-muted">{{ Str::limit($author->bio, 120) }}</td>
            <td class="text-end">
              <a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-sm btn-outline-secondary">Muuda</a>
              <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="d-inline"
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

    {{ $authors->links() }}
  @else
    <div class="alert alert-info mb-0">Autorid puuduvad. Lisa esimene autor.</div>
  @endif
</div>
@endsection
