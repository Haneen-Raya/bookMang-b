<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'cover' => 'nullable|image|max:2048',
            'author_id' => 'required|exists:authors,id',
            'categories' => 'array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'categories.*' => 'exists:categories,id',
        ];
    }
}
