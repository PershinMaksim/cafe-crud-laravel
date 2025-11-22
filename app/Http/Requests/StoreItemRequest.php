<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'sometimes|string|in:true,false,1,0'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название обязательно для заполнения',
            'name.max' => 'Название не должно превышать 255 символов',
            'price.required' => 'Цена обязательна для заполнения',
            'price.numeric' => 'Цена должна быть числом',
            'price.min' => 'Цена не может быть отрицательной',
            'quantity.required' => 'Количество обязательно для заполнения',
            'quantity.integer' => 'Количество должно быть целым числом',
            'quantity.min' => 'Количество не может быть отрицательным',
            'is_active.in' => 'The is active field must be true, false, 1 or 0.',
        ];
    }
}