@extends('layouts.app')

@section('title', 'Raamatud')

@section('content')
    <h1 class="mb-4">Raamatud</h1>

    <form method="GET" action="{{ route('books.index') }}" class="mb-3" role="search" id="live-search-form">
        <div class="input-group">
            <input type="search" name="q" value="{{ old('q', $q ?? request('q')) }}" class="form-control" placeholder="Otsi (min 3 märki): autor, pealkiri, aasta, loodud/uuendatud, lehekülgi" minlength="3" oninput="this.value=this.value.trimStart()" id="search-input" autocomplete="off">
            <button class="btn btn-primary" type="submit">Otsi</button>
            @if(($q ?? request('q')))
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Tühjenda</a>
            @endif
        </div>
        <div class="form-text">Tühikud eemaldatakse algusest; otsing aktiveerub alates 3 märgist.</div>
    </form>

    <div id="results-meta" class="mb-2">
        @if(isset($q) && strlen($q) >= 3)
            <div class="text-muted">Tulemusi: {{ $books->total() }} — päring: "{{ $q }}"</div>
        @endif
    </div>

    <div id="results-container">
        @include('public.books._results', ['books' => $books])
    </div>

    <script>
    (function(){
        const form = document.getElementById('live-search-form');
        const input = document.getElementById('search-input');
        const container = document.getElementById('results-container');
        const meta = document.getElementById('results-meta');

        let controller;
        let timeoutId;

        function updateResultsHTML(html){
            container.innerHTML = html;
        }
        function updateMetaText(text){
            meta.innerHTML = text ? '<div class="text-muted">' + text + '</div>' : '';
        }

        async function fetchResults(q){
            try {
                if (controller) controller.abort();
                controller = new AbortController();
                const params = new URLSearchParams({ q, partial: '1' });
                const res = await fetch(`${form.action}?${params.toString()}`, { headers: { 'X-Requested-With':'XMLHttpRequest' }, signal: controller.signal });
                const html = await res.text();
                updateResultsHTML(html);
                updateMetaText(q.length >= 3 ? `Tulemusi: ${document.querySelectorAll('#results-container .card').length} — päring: "${q}"` : '');
                history.replaceState(null, '', `${form.action}?q=${encodeURIComponent(q)}`);
            } catch (e) { /* ignore aborted */ }
        }

        function handleInput(){
            const q = input.value.trim();
            clearTimeout(timeoutId);
            if (q.length < 3) {
                // when less than 3, load default (no filter)
                updateMetaText('');
                fetchResults('');
                return;
            }
            timeoutId = setTimeout(() => fetchResults(q), 250); // debounce
        }

        input.addEventListener('input', handleInput);
        form.addEventListener('submit', function(ev){ ev.preventDefault(); handleInput(); });
    })();
    </script>
@endsection
