@csrf

<div class="mb-3">
  <label class="form-label" for="name">Nimi</label>
  <input type="text" name="name" id="name" class="form-control"
         value="{{ old('name', $author->name ?? '') }}" required>
  @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label" for="bio">Bio</label>
  <textarea name="bio" id="bio" rows="4" class="form-control">{{ old('bio', $author->bio ?? '') }}</textarea>
  @error('bio')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="d-flex gap-2">
  <button class="btn btn-primary">{{ $submitLabel ?? 'Salvesta' }}</button>
  <a href="{{ route('admin.authors.index') }}" class="btn btn-outline-secondary">Tühista</a>
</div>
