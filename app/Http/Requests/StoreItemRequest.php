<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Если чекбокс не отмечен, поле не приходит, устанавливаем false
        if (!$this->has('is_active')) {
            $this->merge([
                'is_active' => false,
            ]);
        } else {
            // Если пришло значение, преобразуем его в boolean
            $this->merge([
                'is_active' => (bool)$this->is_active,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];
    }
}