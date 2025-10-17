@extends('layouts.app')

@section('title', 'Raamatud')

@section('content')
    <h1 class="mb-4">Raamatud</h1>

    @include('public.books._results', ['books' => $books])
@endsection
