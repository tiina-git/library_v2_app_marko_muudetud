@extends('layouts.app')

@section('title', 'Impordi raamatud CSV-ist')

@section('content')
<div class="container my-4">
    <h1 class="mb-4">Impordi raamatud (CSV)</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card p-3">
        <form method="POST" action="{{ route('admin.books.import') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="csv" class="form-label">CSV fail (semikoloniga eraldatud, esimesel real päised)</label>
                <input type="file" id="csv" name="csv" accept=".csv,text/csv" class="form-control" required>
                @error('csv') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Impordi</button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Tühista</a>
            </div>
        </form>
    </div>
</div>
@endsection