@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">👤 {{ $user->name }}'s Profile</h3>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    User Information
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Status:</strong> 
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                    <p><strong>Roles:</strong> 
                        @foreach($user->getRoleNames() as $role)
                            <span class="badge bg-info text-dark">{{ $role }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold">📚 Borrowing History</h5>

    <div class="card shadow-sm mt-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Book</th>
                        <th>Borrowed At</th>
                        <th>Due At</th>
                        <th>Returned At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $record)
                        <tr>
                            <td>{{ $record->book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->borrowed_at)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->due_at)->format('d M Y') }}</td>
                            <td>
                                @if($record->returned_at)
                                    {{ \Carbon\Carbon::parse($record->returned_at)->format('d M Y') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($record->returned_at)
                                    <span class="badge bg-success">Returned</span>
                                @elseif(now()->gt($record->due_at))
                                    <span class="badge bg-danger">Overdue</span>
                                @else
                                    <span class="badge bg-warning">Borrowed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No borrowing records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
