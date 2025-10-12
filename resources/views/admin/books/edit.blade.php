@extends('layouts.app')

@section('title', 'Muuda raamatut')

@section('content')
<div class="container my-4">
  <h1 class="h4 mb-3">Muuda raamatut</h1>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.books.update', $book) }}" method="POST">
        @method('PUT')
        @include('admin.books._form', ['submitLabel' => 'Salvesta muudatused'])
      </form>
    </div>
  </div>
</div>
@endsection
