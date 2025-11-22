<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItemRepository
{
    public function getAll(): Collection
    {
        return Item::all();
    }

    public function findById(int $id): ?Item
    {
        return Item::find($id);
    }

    public function findOrFail(int $id): Item
    {
        $item = $this->findById($id);
        
        if (!$item) {
            throw new ModelNotFoundException("Item with ID {$id} not found");
        }
        
        return $item;
    }

    public function create(array $data): Item
    {
        return Item::create($data);
    }

    public function update(int $id, array $data): Item
    {
        \Log::info("=== REPOSITORY UPDATE ===");
        \Log::info("Updating item ID: {$id}");
        \Log::info("Data received: ", $data);
        
        $item = $this->findOrFail($id);
        \Log::info("Item before update: ", $item->toArray());
        
        // Проверим, есть ли изменения
        $changes = [];
        foreach ($data as $key => $value) {
            if ($item->$key != $value) {
                $changes[$key] = "{$item->$key} => {$value}";
            }
        }
        \Log::info("Detected changes: ", $changes);
        
        $item->update($data);
        
        // Обновим модель из базы
        $item = $item->fresh();
        \Log::info("Item after update: ", $item->toArray());
        
        return $item;
}

    public function delete(int $id): bool
    {
        $item = $this->findOrFail($id);
        return $item->delete();
    }
}