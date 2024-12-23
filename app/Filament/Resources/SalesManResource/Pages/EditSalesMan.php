<?php

namespace App\Filament\Resources\SalesManResource\Pages;

use App\Filament\Resources\SalesManResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSalesMan extends EditRecord
{
    protected static string $resource = SalesManResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make()
            // ,
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        $record->inventory()->update(['title' => $record->full_name]);
        $record->user()->update(['name' => $record->full_name]);

        return $record;
    }

}
