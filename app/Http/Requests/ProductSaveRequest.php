<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSaveRequest extends FormRequest
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
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
            'category_id' => ['nullable'],
            'image' => ['nullable'],
            'status' => ['required'],
            'is_favorite' => ['required'],
            'sku' => ['required'],
            'bar_code' => ['required'],
            'quantity' => ['required'],
        ];
    }

    public function messages(){
        return [
            'name.required' => ' Product Name is required',
        ];
    }
}
