<?php

namespace App\Filament\Resources\BranchResource\Pages;

use App\Models\Branch;
use App\Filament\Resources\BranchResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\ViewEntry;

class BranchView extends ViewRecord
{
    protected static string $resource = BranchResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ViewEntry::make('livewire')
                    ->view('app.branch.view', ['branch' => $infolist->record])
                    ->columnSpanFull(),
            ]);
    }    
}
