<?php

namespace App\Service;

use App\Models\Receipt;
use Filament\Forms\Components;

class PaymentService
{

    public static function showReceipt(Receipt $receipt)
    {
        // 'title',
        // 'code',
        // 'total_amount',
        // 'discount_amount',
        // 'amount',
        // 'paid',
        return [
            Components\TextInput::make('title')
                ->label('title')
                ->default($receipt->title)
                ->readOnly(),
            Components\TextInput::make('total_amount')
                ->label('title')
                ->default($receipt->total_amount)
                ->readOnly(),
            Components\TextInput::make('discount_amount')
                ->label('discount amount')
                ->default($receipt->discount_amount)
                ->readOnly(),
            Components\TextInput::make('paid')
                ->label('paid')
                ->default($receipt->paid)
                ->readOnly(),
        ];
    }

}