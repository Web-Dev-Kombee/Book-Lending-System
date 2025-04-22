@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Book: {{ $book->title }}</h2>

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('books._form')
        <button type="submit" class="btn btn-success">Update Book</button>
    </form>
</div>
@endsection
