@extends('layouts.app')

@section('title', 'Muuda autorit')

@section('content')
<div class="container my-4">
  <h1 class="h4 mb-3">Muuda autorit</h1>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.authors.update', $author) }}" method="POST">
        @method('PUT')
        @include('admin.authors._form', ['submitLabel' => 'Salvesta muudatused'])
      </form>
    </div>
  </div>
</div>
@endsection
