<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'price' => 'required|min:1',
            'qty' => 'required|min:1',
            'description' => 'required',
            'status' => 'boolean',
            'product_category_id' => 'required',
            'image' => 'required',
            'slug' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Ten buoc phai nhap.',
            'name.min' => 'Ten it nhat 3 ky tu.',
            'name.max' => 'Ten nhieu nhat 10 ky tu.',
            'status.required' => 'Trang thai buoc phai nhap.'
        ];
    }
}
