<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLendingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust if you want to restrict access
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_at'  => 'required|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Please select a book.',
            'book_id.exists' => 'The selected book does not exist.',
            'user_id.required' => 'Please select a member.',
            'user_id.exists' => 'The selected user does not exist.',
            'due_at.required' => 'Please provide a due date.',
            'due_at.date' => 'The due date must be a valid date.',
            'due_at.after' => 'The due date must be after today.',
        ];
    }
}

