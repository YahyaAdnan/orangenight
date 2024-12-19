<?php

namespace App\Filament\Resources\SalesManResource\Pages;

use App\Filament\Resources\SalesManResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\ViewEntry;

class SalesManView extends ViewRecord
{
    protected static string $resource = SalesManResource::class;


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ViewEntry::make('livewire')
                    ->view('app.sales-man.view', ['salesMan' => $infolist->record])
                    ->columnSpanFull(),
            ]);
    }
}
