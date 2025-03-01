<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetBoatsRequest extends FormRequest
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
            'boat_type' => 'nullable|string|in:all,motor,sailing',
            'condition' => 'nullable|string|in:all,new,used',
            'boat_model_id' => 'nullable|exists:boat_models,id',
            'length' => 'nullable|array|size:2',
            'length.*' => 'numeric',
            'year' => 'nullable|array|size:2',
            'year.*' => 'numeric',
            'price' => 'nullable|array|size:2',
            'price.*' => 'numeric',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'sort' => 'nullable|string|in:price,length,year,created_at',
            'direction' => 'nullable|string|in:asc,desc',
            'per_page' => 'nullable|integer|min:1',
        ];
    }
}
