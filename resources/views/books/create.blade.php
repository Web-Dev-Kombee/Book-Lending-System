@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Book</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" id="bookForm">
        @csrf
        @include('books._form', ['book' => new \App\Models\Book])

        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Save Book</button>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('bookForm');
        const submitBtn = document.getElementById('submitBtn');
        const inputs = form.querySelectorAll('input, textarea');
        
        // Real-time validation on input change
        form.addEventListener('input', function() {
            let isValid = true;

            inputs.forEach(input => {
                // Check if the input field is valid
                if (!input.checkValidity()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Enable or disable submit button
            submitBtn.disabled = !isValid;
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let formValid = true;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    formValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (formValid) {
                form.submit();
            }
        });
    });
</script>
@endpush
@endsection
