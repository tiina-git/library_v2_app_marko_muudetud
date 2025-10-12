@extends('layouts.app')

@section('title', 'Töölaud')

@section('content')
<div class="container my-4">
  <h1 class="h4 mb-3">Töölaud</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="row g-3">
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Raamatuid kokku</div>
        <div class="display-6">{{ $bookCount }}</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Autoreid kokku</div>
        <div class="display-6">{{ $authorCount }}</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Keskmine raamatuid autoril</div>
        <div class="display-6">{{ $avgBooksPerAuthor }}</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Viljakaim autor</div>
        <div class="h5 mb-0">
          {{ $topAuthor?->name ?? '—' }}
        </div>
        <div class="text-muted small">
          {{ $topAuthor?->books_count ? $topAuthor->books_count.' raamatut' : '' }}
        </div>
      </div></div>
    </div>

    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Muutmata raamatud</div>
        <div class="display-6">{{ $unchangedBooks }}</div>
        <div class="text-muted small">created_at = updated_at</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Muudetud raamatud</div>
        <div class="display-6">{{ $changedBooks }}</div>
        <div class="text-muted small">created_at ≠ updated_at</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Muutmata autorid</div>
        <div class="display-6">{{ $unchangedAuthors }}</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Muudetud autorid</div>
        <div class="display-6">{{ $changedAuthors }}</div>
      </div></div>
    </div>

    {{-- Valikulised lisad --}}
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">ISBN puudub</div>
        <div class="display-6">{{ $booksWithoutIsbn }}</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Aasta puudub</div>
        <div class="display-6">{{ $booksWithoutYear }}</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card h-100"><div class="card-body">
        <div class="fw-bold">Vanim / Uusim aasta</div>
        <div class="h5 mb-0">{{ $oldestYear ?? '—' }} / {{ $newestYear ?? '—' }}</div>
      </div></div>
    </div>
  </div>
</div>
@endsection
