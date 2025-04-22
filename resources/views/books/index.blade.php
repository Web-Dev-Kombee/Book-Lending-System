@extends('layouts.app')
@hasanyrole('admin|librarian')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-book me-2"></i>Books Management</h5>
            <a href="{{ route('books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Book
            </a>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="bookSearch" class="form-control border-start-0" placeholder="Search books by title, author, or ISBN...">
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="booksTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px">Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th style="width: 100px" class="text-center">Total Copies</th>
                            <th style="width: 100px" class="text-center">Available</th>
                            <th style="width: 180px" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>
                                <div class="book-cover">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-thumbnail">
                                    @else
                                        <div class="no-cover d-flex align-items-center justify-content-center text-muted">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong>{{ $book->title }}</strong>
                                @if($book->publication_year)
                                    <div class="text-muted small">{{ $book->publication_year }}</div>
                                @endif
                            </td>
                            <td>{{ $book->author }}</td>
                            <td><span class="badge bg-light text-dark">{{ $book->isbn }}</span></td>
                            <td class="text-center">{{ $book->description }}</td>
                            <td class="text-center">{{ $book->is_active }}</td>
                            <td class="text-center">{{ $book->total_copies }}</td>
                            <td class="text-center">
                                @if($book->available_copies > 0)
                                    <span class="badge bg-success">{{ $book->available_copies }}</span>
                                @else
                                    <span class="badge bg-danger">0</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#bookDetailsModal{{ $book->id }}" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Book Details Modal -->
                                <div class="modal fade" id="bookDetailsModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $book->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 text-center mb-3 mb-md-0">
                                                        @if($book->cover_image)
                                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid rounded">
                                                        @else
                                                            <div class="no-cover large d-flex align-items-center justify-content-center text-muted">
                                                                <i class="fas fa-book-open fa-3x"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-4">Author</dt>
                                                            <dd class="col-sm-8">{{ $book->author }}</dd>
                                                            
                                                            <dt class="col-sm-4">ISBN</dt>
                                                            <dd class="col-sm-8">{{ $book->isbn }}</dd>
                                                            
                                                           
                                                            
                                                            <dt class="col-sm-4">Status</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $book->available_copies }} of {{ $book->total_copies }} available
                                                            </dd>
                                                            
                                                           
                                                                <dt class="col-12 mt-2">Description</dt>
                                                                <dd class="col-12">
                                                                    <p class="small text-muted">{{ $book->description }}</p>
                                                                </dd>
                                                      
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('books.edit', $book) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center text-muted">
                                    <i class="fas fa-books fa-3x mb-3"></i>
                                    <h5>No books found</h5>
                                    <p>Your library is empty. Start by adding some books.</p>
                                    <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i> Add First Book
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
    {{ $books->links('pagination::bootstrap-5') }}
</div>

        </div>
    </div>
</div>

<style>
    .book-cover {
        width: 60px;
        height: 80px;
        overflow: hidden;
        border-radius: 4px;
    }
    
    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-cover {
        width: 60px;
        height: 80px;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 4px;
    }
    
    .no-cover.large {
        width: 100%;
        height: 200px;
    }
    
    .delete-btn:hover {
        background-color: #dc3545;
        color: white;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.03);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('bookSearch');
        const table = document.getElementById('booksTable');
        const rows = table.querySelectorAll('tbody tr');
        
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            
            rows.forEach(row => {
                const title = row.cells[1].textContent.toLowerCase();
                const author = row.cells[2].textContent.toLowerCase();
                const isbn = row.cells[3].textContent.toLowerCase();
                
                if (title.includes(query) || author.includes(query) || isbn.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Delete confirmation using SweetAlert if available, otherwise fallback to confirm
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            const deleteBtn = form.querySelector('.delete-btn');
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This book will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (confirm('Are you sure you want to delete this book?')) {
                        form.submit();
                    }
                }
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