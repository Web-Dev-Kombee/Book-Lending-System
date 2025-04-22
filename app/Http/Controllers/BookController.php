<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\StoreBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created book in storage.
     */
   

    public function store(StoreBookRequest $request)
{
    $validated = $request->validated();

    $validated['available_copies'] = $validated['total_copies'];

    if ($request->hasFile('cover_image')) {
        $validated['cover_image'] = $request->file('cover_image')->store('book_covers', 'public');
    }

    Book::create($validated);

    return redirect()->route('books.index')->with('success', 'Book created successfully.');
}

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified book in storage.
     */
    // public function update(Request $request, Book $book)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'author' => 'required|string|max:255',
    //         'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
    //         'total_copies' => 'required|integer|min:1',
    //         'description' => 'nullable|string',
    //         'cover_image' => 'nullable|image|max:2048',
    //         'is_active' => 'sometimes|boolean',
    //     ]);

    //     if ($request->hasFile('cover_image')) {
    //         // Delete old image if exists
    //         if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
    //             Storage::disk('public')->delete($book->cover_image);
    //         }
    //         $validated['cover_image'] = $request->file('cover_image')->store('book_covers', 'public');
    //     }

    //     $validated['available_copies'] = $validated['total_copies']; // Optional: could be refined

    //     $book->update($validated);

    //     return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    // }



public function update(UpdateBookRequest $request, Book $book)
{
    $validated = $request->validated();

    if ($request->hasFile('cover_image')) {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $validated['cover_image'] = $request->file('cover_image')->store('book_covers', 'public');
    }

    $validated['available_copies'] = $validated['total_copies']; // Optional

    $book->update($validated);

    return redirect()->route('books.index')->with('success', 'Book updated successfully.');
}


    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
