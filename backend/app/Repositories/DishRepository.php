<?php

namespace App\Repositories;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DishRepository
{
    public function getAll(): Collection
    {
        return Dish::all();
    }

    public function findById(int $id): ?Dish
    {
        return Dish::find($id);
    }

    public function findOrFail(int $id): Dish
    {
        $dish = $this->findById($id);
        
        if (!$dish) {
            throw new ModelNotFoundException("Dish with ID {$id} not found");
        }
        
        return $dish;
    }

    public function create(array $data): Dish
    {
        return Dish::create($data);
    }

    public function update(int $id, array $data): Dish
    {
        \Log::info("=== REPOSITORY UPDATE ===");
        \Log::info("Updating dish ID: {$id}");
        \Log::info("Data received: ", $data);
        
        $dish = $this->findOrFail($id);
        \Log::info("Dish before update: ", $dish->toArray());
        
        // Проверим, есть ли изменения
        $changes = [];
        foreach ($data as $key => $value) {
            if ($dish->$key != $value) {
                $changes[$key] = "{$dish->$key} => {$value}";
            }
        }
        \Log::info("Detected changes: ", $changes);
        
        $dish->update($data);
        
        // Обновим модель из базы
        $dish = $dish->fresh();
        \Log::info("Dish after update: ", $dish->toArray());
        
        return $dish;
}

    public function delete(int $id): bool
    {
        $dish = $this->findOrFail($id);
        return $dish->delete();
    }
}