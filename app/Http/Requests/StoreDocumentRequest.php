<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * (Abhi authentication nahi hai, isliye sabko allow kar rahe hain)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * Yahan hum file ki security aur limits define karenge.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:2048',],
            'disk' => 'required|in:public,local',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'File title required.',
            'file.required' => 'Select file.',
            'file.file' => 'Not a valid file .',
            'file.mimes' => 'Only JPG, PNG, PDF, DOC, DOCX formats allowed .',
            'file.max' => 'File size cannot be more than 2MB .',
            'disk.required' => 'Please select storage type (Public or Private)',
            'disk.in' => 'Storage type only "public" OR "local".',
        ];
    }
}