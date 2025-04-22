<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LendingRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLendingRequest;


class LendingController extends Controller
{
    // List all lending records (admin/librarian)
    public function index()
    {
        $lendings = LendingRecord::with('book', 'user')->latest()->paginate(10);
        return view('lendings.index', compact('lendings'));
    }

    // Show form to lend a book
    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $users = \App\Models\User::role('member')->get();

        return view('lendings.create', compact('books', 'users'));
    }

    // Store a new lending record
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'book_id' => 'required|exists:books,id',
    //         'user_id' => 'required|exists:users,id',
    //         'due_at' => 'required|date|after:today',
    //     ]);

    //     $book = Book::findOrFail($validated['book_id']);

    //     if ($book->available_copies <= 0) {
    //         return back()->withErrors(['book_id' => 'No available copies left.']);
    //     }

    //     LendingRecord::create([
    //         'book_id' => $validated['book_id'],
    //         'user_id' => $validated['user_id'],
    //         'due_at' => $validated['due_at'],
    //         'borrowed_at' => now(),
    //         'returned_at' => null,
    //     ]);

    //     $book->decrement('available_copies');

    //     return redirect()->route('lendings.index')->with('success', 'Book lent successfully.');
    // }

    public function store(StoreLendingRequest $request)
{
    $validated = $request->validated();

    $book = Book::findOrFail($validated['book_id']);

    if ($book->available_copies <= 0) {
        return back()->withErrors(['book_id' => 'No available copies left.']);
    }

    LendingRecord::create([
        'book_id'     => $validated['book_id'],
        'user_id'     => $validated['user_id'],
        'due_at'      => $validated['due_at'],
        'borrowed_at' => now(),
        'returned_at' => null,
    ]);

    $book->decrement('available_copies');

    return redirect()->route('lendings.index')->with('success', 'Book lent successfully.');
}

    // Mark a book as returned
    public function returnBook(LendingRecord $lending)
    {
        if ($lending->returned_at) {
            return back()->with('error', 'Book already returned.');
        }

        $lending->update(['returned_at' => now()]);
        $lending->book->increment('available_copies');

        return back()->with('success', 'Book marked as returned.');
    }

    // Show books borrowed by the logged-in member
    public function myBorrowedBooks()
    {
        $lendings = \App\Models\LendingRecord::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    
        return view('lendings.my_books', compact('lendings'));
    }
    
}
