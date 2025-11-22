<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDishRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'name' => 'required|string|max:255', // убрать sometimes
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0', // убрать sometimes
        'quantity' => 'required|integer|min:0', // убрать sometimes
        'is_active' => 'required|boolean' // убрать sometimes
    ];
    }

    protected function prepareForValidation()
    {
        \Log::info("=== PREPARE FOR VALIDATION ===");
        \Log::info("Original data: ", $this->all());
        
        // Преобразуем все поля
        $this->merge([
            'name' => (string) $this->name,
            'description' => $this->description ? (string) $this->description : null,
            'price' => (float) $this->price,
            'quantity' => (int) $this->quantity,
            'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN)
        ]);
        
        \Log::info("After preparation: ", $this->all());
    }
}