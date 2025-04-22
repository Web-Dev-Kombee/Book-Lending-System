@extends('layouts.app')

@hasanyrole('admin|librarian')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>User Management</h5>
            @can('manage books')
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add User
            </a>
            @endcan
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="userSearch" class="form-control border-start-0" placeholder="Search by name or email...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-md-end" id="roleFilters">
                        <button class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
                        <button class="btn btn-outline-secondary filter-btn" data-filter="admin">Admin</button>
                        <button class="btn btn-outline-secondary filter-btn" data-filter="librarian">Librarian</button>
                        <button class="btn btn-outline-secondary filter-btn" data-filter="member">Member</button>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th>User Details</th>
                            <th>Contact Information</th>
                            <th style="width: 150px">Roles</th>
                            <th>Activity</th>
                            <th style="width: 180px" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr data-roles="{{ implode(',', $user->roles->pluck('name')->toArray()) }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3 fs-5">{{ substr($user->name, 0, 1) }}</div>
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <div class="text-muted small">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div><i class="fas fa-envelope text-muted me-2 small"></i>{{ $user->email }}</div>
                                    @if(isset($user->phone))
                                        <div class="mt-1"><i class="fas fa-phone text-muted me-2 small"></i>{{ $user->phone }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    @php
                                        $badgeClass = 'bg-secondary';
                                        $roleName = strtolower($role->name);
                                        
                                        if ($roleName === 'admin') {
                                            $badgeClass = 'bg-danger';
                                        } elseif ($roleName === 'librarian') {
                                            $badgeClass = 'bg-success';
                                        } elseif ($roleName === 'member') {
                                            $badgeClass = 'bg-primary';
                                        } elseif ($roleName === 'staff') {
                                            $badgeClass = 'bg-purple';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} mb-1">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="small">
                                        <span class="text-muted">Registered:</span>
                                        <span class="ms-1">{{ $user->created_at->format('d M Y') }}</span>
                                    </div>
                                    @if(isset($user->last_login_at))
                                    <div class="small mt-1">
                                        <span class="text-muted">Last login:</span>
                                        <span class="ms-1">{{ \Carbon\Carbon::parse($user->last_login_at)->format('d M Y H:i') }}</span>
                                    </div>
                                    @endif
                                    @isset($user->borrowings_count)
                                    <div class="small mt-1">
                                        <span class="text-muted">Books borrowed:</span>
                                        <span class="ms-1 fw-semibold">{{ $user->borrowings_count }}</span>
                                    </div>
                                    @endisset
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('manage books')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endcan
                                </div>
                                
                                <!-- User Quick Actions Dropdown -->
                                <div class="dropdown d-inline-block ms-1">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="userActions{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userActions{{ $user->id }}">
                                        <li><a class="dropdown-item" href="{{ route('users.borrowings', $user->id) }}">
                                            <i class="fas fa-book me-2"></i>View Borrowings
                                        </a></li>
                            

                                      

                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Delete User Modal -->
                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete user <strong>{{ $user->name }}</strong>?</p>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            This action cannot be undone and will remove all user data.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete User</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5>No users found</h5>
                                    <p>There are no user accounts in the system.</p>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i> Create First User
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing <span class="fw-semibold" id="visibleCount">{{ count($users) }}</span> of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #4361ee;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .filter-btn.active {
        background-color: #4361ee;
        color: white;
        border-color: #4361ee;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('userSearch');
        const table = document.getElementById('usersTable');
        const rows = table.querySelectorAll('tbody tr:not([data-empty])');
        
        // Update visible count function
        function updateVisibleCount() {
            const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"]):not([data-empty])');
            document.getElementById('visibleCount').textContent = visibleRows.length;
        }
        
        // Search filter
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            
            rows.forEach(row => {
                const userData = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const userEmail = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (userData.includes(query) || userEmail.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateVisibleCount();
        });
        
        // Role filter buttons
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter rows
                rows.forEach(row => {
                    const roles = row.getAttribute('data-roles');
                    if (filter === 'all' || roles.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                updateVisibleCount();
            });
        });
        
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const closeButton = alert.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.click();
                }
            }, 5000);
        });
    });
</script>
@endsection
@endhasanyrole