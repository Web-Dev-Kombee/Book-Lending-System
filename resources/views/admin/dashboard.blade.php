@extends('layouts.app')


@hasanyrole('admin|librarian')
@section('content')
<div class="container py-5">
    <h2 class="mb-5 fw-bold text-primary">📊 Admin Dashboard</h2>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Users</div>
                    <div class="display-6 fw-semibold text-primary">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Books</div>
                    <div class="display-6 fw-semibold text-success">{{ $totalBooks }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Borrowed Books</div>
                    <div class="display-6 fw-semibold text-warning">{{ $borrowedBooks }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Available Books</div>
                    <div class="display-6 fw-semibold text-info">{{ $availableBooks }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lending Table -->
    <div class="card border-0 shadow rounded-3">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">📖 Recent Lending Records</h5>
            <a href="{{ route('lendings.index') }}" class="btn btn-sm btn-outline-primary">
                View All
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Book</th>
                        <th>Borrower</th>
                        <th>Borrowed At</th>
                        <th>Due At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLendings as $lending)
                        <tr>
                            <td class="fw-medium">{{ $lending->book->title }}</td>
                            <td>{{ $lending->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($lending->borrowed_at)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($lending->due_at)->format('d M Y') }}</td>
                            <td>
                                @if($lending->returned_at)
                                    <span class="badge bg-success">Returned</span>
                                @else
                                    <span class="badge bg-danger">Borrowed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No lending records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@endhasanyrole

