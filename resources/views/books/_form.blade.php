<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required minlength="3" maxlength="255">
    <div class="invalid-feedback">Please provide a valid title (between 3 and 255 characters).</div>
</div>

<div class="mb-3">
    <label>Author</label>
    <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" required minlength="3" maxlength="255">
    <div class="invalid-feedback">Please provide a valid author name (between 3 and 255 characters).</div>
</div>

<div class="mb-3">
    <label>ISBN</label>
    <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}" required pattern="\d{13}">
    <div class="invalid-feedback">Please provide a valid ISBN (13 digits only).</div>
</div>

<div class="mb-3">
    <label>Total Copies</label>
    <input type="number" name="total_copies" class="form-control" value="{{ old('total_copies', $book->total_copies) }}" required min="1">
    <div class="invalid-feedback">Please provide a valid number of copies (at least 1).</div>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $book->description) }}</textarea>
</div>

<div class="mb-3">
    <label>Cover Image</label>
    <input type="file" name="cover_image" class="form-control">
    @if($book->cover_image)
        <small>Current:</small><br>
        <img src="{{ asset('storage/' . $book->cover_image) }}" width="100" class="mt-2">
    @endif
</div>

@if(Route::currentRouteName() === 'books.edit')
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $book->is_active ? 'checked' : '' }}>
        <label class="form-check-label">Active</label>
    </div>
@endif
