<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    // Указываем правильное имя таблицы
    protected $table = 'dishes';

    // Указываем fillable поля
    protected $fillable = ['name', 'description', 'price', 'quantity', 'is_active'];

    // Указываем типы данных для автоматического приведения типов
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean'
    ];
}