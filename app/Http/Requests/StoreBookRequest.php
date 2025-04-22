<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to false if only admins can create books
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'isbn'          => 'required|string|max:20|unique:books,isbn',
            'total_copies'  => 'required|integer|min:1',
            'description'   => 'nullable|string',
            'cover_image'   => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'The book title is required.',
            'author.required'       => 'The author name is required.',
            'isbn.required'         => 'ISBN is required.',
            'isbn.unique'           => 'This ISBN already exists.',
            'total_copies.required' => 'Total copies field is required.',
            'cover_image.image'     => 'The cover must be a valid image.',
            'cover_image.max'       => 'Cover image must be under 2MB.',
        ];
    }
}
