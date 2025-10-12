@extends('layouts.app')

@section('title', 'Lisa raamat')

@section('content')
<div class="container my-4">
  <h1 class="h4 mb-3">Lisa raamat</h1>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.books.store') }}" method="POST">
        @include('admin.books._form', ['submitLabel' => 'Lisa raamat'])
      </form>
    </div>
  </div>
</div>
@endsection
