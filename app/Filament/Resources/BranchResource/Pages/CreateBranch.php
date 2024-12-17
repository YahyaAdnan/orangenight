<?php

namespace App\Filament\Resources\BranchResource\Pages;

use App\Models\Branch;
use App\Models\Inventory;
use App\Filament\Resources\BranchResource;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $inventory = Inventory::create(['title' => $data['title']]);

        return Branch::create([
            'title' => $data['title'], 
            'inventory_id' => $inventory->id,
        ]);
    }
}
