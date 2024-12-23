<?php

namespace App\Service;

use App\Models\Receipt;
use App\Models\Payment;
use Filament\Forms\Components;
use Filament\Forms\Get;

class PaymentService
{

    public static function showReceipt(Receipt $receipt)
    {
        return [
            Components\TextInput::make('title')
                ->label('title')
                ->default($receipt->title)
                ->readOnly(),
            Components\TextInput::make('total_amount')
                ->label('total amount')
                ->default($receipt->total_amount)
                ->readOnly(),
            Components\TextInput::make('discount_amount')
                ->label('discount amount')
                ->default($receipt->discount_amount)
                ->readOnly(),
            Components\Repeater::make('payments')
                ->schema([
                    Components\Grid::make([
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Components\TextInput::make('total_amount')
                            ->label('Payment Amount')
                            ->readOnly()
                            ->default(fn ($record) => $record['total_amount']),
                        Components\DatePicker::make('payment_date')
                            ->label('Payment Date')
                            ->displayFormat('d/m/Y')
                            ->readOnly()
                            ->default(fn ($record) => $record['created_at']),
                    ])
                ])
                ->default(fn () => $receipt->payments->map(fn ($payment) => [
                    'total_amount' => $payment->total_amount,
                    'created_at' => $payment->created_at,
                ])->toArray())
                ->disableItemCreation()
                ->disableItemDeletion()
                ->columnSpanFull(),
        ];
    }

    public static function form(Receipt $receipt)
    {
        // 'customer_id',
        // 'receipt_id',
        // 'total_amount',
        // 'paid',
        // 'returned',
        return [
            Components\TextInput::make('required_amount')
                        ->label(__('total_amount'))
                        ->default($receipt->total_amount - $receipt->paid)
                        ->disabled(),
            Components\Grid::make([
                'sm' => 1,
                'md' => 2,
            ])
                ->schema([
                    Components\TextInput::make('total_amount')
                        ->label(__('amount'))
                        ->numeric()
                        ->default($receipt->total_amount - $receipt->paid)
                        ->minValue(1)
                        ->maxValue($receipt->total_amount - $receipt->paid)
                        ->live(),
                    Components\TextInput::make('paid')
                        ->label(__('paid'))
                        ->numeric()
                        ->minValue(fn(Get $get) => $get('total_amount'))
                        ->live(),
                ]),
            Forms\Components\TextInput::make('note')
                ->label(__('note'))
                ->maxLength(255),
        ];
    }

    public static function store(Receipt $receipt, $data)
    {
        $payment = Payment::create([
            'customer_id' => $receipt->customer_id,
            'receipt_id' => $receipt->id,
            'total_amount' => $data['total_amount'],
            'paid' => $data['paid'],
            'returned' => $data['paid'] - $data['total_amount'],
            'note' => $data['note']
        ]);

        $receipt->paid += $payment->total_amount;
        $receipt->save();

        return $payment;
    }

}