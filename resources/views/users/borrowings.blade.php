@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">{{ $user->name }}'s Borrowed Books</h3>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Book</th>
                <th>Borrowed At</th>
                <th>Due Date</th>
                <th>Returned At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($user->lendingRecords as $lending)
                <tr>
                    <td>{{ $lending->book->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($lending->borrowed_at)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($lending->due_at)->format('d M Y') }}</td>
                    <td>
                        @if ($lending->returned_at)
                            {{ \Carbon\Carbon::parse($lending->returned_at)->format('d M Y') }}
                        @else
                            <span class="text-muted">Not returned</span>
                        @endif
                    </td>
                    <td>
                        @if ($lending->returned_at)
                            <span class="badge bg-success">Returned</span>
                        @elseif (now()->gt($lending->due_at))
                            <span class="badge bg-danger">Overdue</span>
                        @else
                            <span class="badge bg-warning">Borrowed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No borrowings found for this user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">← Back to Users</a>
</div>
@endsection
