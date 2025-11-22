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
        $item = $this->findOrFail($id);
        $item->update($data);
        
        return $item->fresh();
    }

    public function delete(int $id): bool
    {
        $item = $this->findOrFail($id);
        return $item->delete();
    }
}