<?php

namespace App\Livewire;

use App\Models\InventoryMovement;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InventoryMovementTable extends BaseWidget
{
    public $model, $inventory;

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->inventory = $model->inventory;
    }

    protected function getTableHeading(): ?string
    {
        return __('inventory_movements');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InventoryMovement::where('from_inventory_id', $this->inventory->id)
                    ->orWhere('to_inventory_id', $this->inventory->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label(__('type')),
                Tables\Columns\TextColumn::make('item.title')
                    ->label(__('item'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fromInventory.title')
                    ->label(__('from'))
                    ->badge()
                    ->color('danger')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('toInventory.title')
                    ->label(__('to'))
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('quantity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('sales_man'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->label(__('note'))
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime('Y-m-d h:ia')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('type'))
                    ->multiple()
                    ->options([
                        'move' => __('move'),
                        'sold' => __('sold'),
                        'import' => __('import'),
                        'distribution' => __('distribution'),
                        'Delete' => __('delete'),
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('from')),
                        Forms\Components\DatePicker::make('created_until')
                            ->label(__('to'))
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        if (!empty($data['created_from'])) {
                            $query->whereDate('created_at', '>=', $data['created_from']);
                        }
    
                        if (!empty($data['created_until'])) {
                            $query->whereDate('created_at', '<=', $data['created_until']);
                        }
    
                        return $query;
                    }),
            ]);
    }
}
