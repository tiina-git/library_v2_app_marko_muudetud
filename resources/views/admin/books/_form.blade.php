@csrf

<div class="mb-3">
  <label class="form-label" for="title">Pealkiri</label>
  <input type="text" name="title" id="title" class="form-control"
         value="{{ old('title', $book->title ?? '') }}" required>
  @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label" for="author_id">Autor</label>
  <select name="author_id" id="author_id" class="form-select" required>
    <option value="" disabled {{ old('author_id', $book->author_id ?? '') ? '' : 'selected' }}>Vali autor…</option>
    @foreach($authors as $author)
      <option value="{{ $author->id }}"
        {{ (string)old('author_id', $book->author_id ?? '') === (string)$author->id ? 'selected' : '' }}>
        {{ $author->name }}
      </option>
    @endforeach
  </select>
  @error('author_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="row g-3">
  <div class="col-sm-4">
    <label class="form-label" for="published_year">Aasta</label>
    <input type="number" name="published_year" id="published_year" class="form-control"
           value="{{ old('published_year', $book->published_year ?? '') }}" min="0" max="2100" inputmode="numeric">
    @error('published_year')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>
  <div class="col-sm-4">
    <label class="form-label" for="isbn">ISBN</label>
    <input type="text" name="isbn" id="isbn" class="form-control"
           value="{{ old('isbn', $book->isbn ?? '') }}">
    @error('isbn')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>
  <div class="col-sm-4">
    <label class="form-label" for="pages">Lehti</label>
    <input type="number" name="pages" id="pages" class="form-control"
           value="{{ old('pages', $book->pages ?? '') }}" min="1" inputmode="numeric">
    @error('pages')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
  </div>
</div>

<div class="d-flex gap-2 mt-3">
  <button class="btn btn-primary">{{ $submitLabel ?? 'Salvesta' }}</button>
  <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Tühista</a>
</div>
