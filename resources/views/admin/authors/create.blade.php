@extends('layouts.app')

@section('title', 'Lisa autor')

@section('content')
<div class="container my-4">
  <h1 class="h4 mb-3">Lisa autor</h1>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.authors.store') }}" method="POST">
        @include('admin.authors._form', ['submitLabel' => 'Lisa autor'])
      </form>
    </div>
  </div>
</div>
@endsection
