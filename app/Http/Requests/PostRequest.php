<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'type' => 'required',
            'slug' => 'string',
            'title' => 'required|string',
            'excerpt' => 'string',
            'content' => 'required|string',
            'data_json' => 'required|string',
            'language' => 'required',
            'status' => 'required',
            'guid' => 'string',
            'menu_order' => 'required',
            'ordered' => 'required',
            'mime_type' => 'string',
        ];
    }
}
