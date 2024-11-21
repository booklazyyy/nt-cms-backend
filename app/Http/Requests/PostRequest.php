<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\File;
use App\Http\Helpers\Helper;

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
            'title' => [
                'required_if:type,!attachment', // required ถ้า type ไม่ใช่ attachment
                'string',
            ],
            'excerpt' => 'string',
            'content' => [
                'required_if:type,!attachment', // required ถ้า type ไม่ใช่ attachment
                'string',
            ],
            'data_json' => 'json',
            'language' => 'required',
            'status' => 'required',
            'guid' => 'string',
            'menu_order' => 'required',
            'ordered' => 'required',
            'mime_type' => 'string',
            // when type is attachment
            'files' => [
                'required_if:type,attachment',
                'array'
            ],
            'files.*' => 'required_if:type,attachment|file|mimes:jpg,jpeg,png,gif|max:10240', // ตรวจสอบแต่ละไฟล์ใน array
        ];
    }

    public function failedValidation(Validator $validator)
    {
        Helper::sendError('Validation errors', $validator->errors());
    }
}
