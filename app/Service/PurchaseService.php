<?php

namespace App\Service;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Receipt;
use App\Models\Item;
use App\Models\Delivery;
use Filament\Forms\Components;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PurchaseService
{
    // 'date',
    // 'customer_id',
    // 'user_id',
    // 'receipt_id',
    // 'items',

    public static function form(?Customer $customer = null)
    {
        $customers = $customer == null ?
            Customer::pluck('full_name', 'id')
            : Customer::where('id', $customer?->id)->pluck('full_name', 'inventory_id');

            return [
            Components\DatePicker::make('date')
                ->label(__('date'))
                ->format('d/m/Y')
                ->required()
                ->rules('after_or_equal:today')
                ->default(now()),
            Components\Select::make('customer_id')
                ->label(__('customer'))
                ->searchable()
                ->required()
                ->default(fn() => $customer != null ? $customer->id : null)
                ->options($customers),
            Components\Repeater::make('items')
                ->label(__('items'))
                ->schema([
                    Components\Select::make('item_id')
                        ->label(__('item'))
                        ->options(Item::pluck('title', 'id'))
                        ->searchable()
                        ->required()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    Components\TextInput::make('quantity')
                        ->label(__('quantity'))
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(99)
                ])
                ->minItems(1)
                ->columns(2)
        ];
    }

    public static function store($data)
    {
        $customer = Customer::find($data['customer_id']);

        // CREATE RECEIPT
        $receipt = Receipt::create([
            'title' => $customer->full_name . ' (' . now()->format('d-m-Y H:i') . ')',
            'code' => SubscriptionForm::receiptCode(), //FIXME: LATER COMBINE BOTH THIS and One in SubService to one.
            'customer_id' => $data['customer_id'],
        ]);

        // CREATE PURCHASE
        $purchase = Purchase::create([
            'date' => Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d'),
            'customer_id' => $data['customer_id'],
            'user_id' => Auth::id(),
            'receipt_id' => $receipt->id,
        ]);

        // CREATE DELIVERY
        foreach ($data['items'] as $key => $item)     
        {
            Delivery::create([
                'deliverable_type' => get_class($purchase),
                'deliverable_id' => $purchase->id,
                'customer_id' => $data['customer_id'],
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'date' => Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d'),
            ]);
        }
    }

    public static function updateReceipt(Purchase $purchase)
    {
        $amount = 0;

        foreach ($purchase->deliveries as $key => $delivery) 
        {
            $amount += $delivery->item->selling_price;
        }

        $purchase->receipt->update([
            'total_amount' => $amount - $purchase->receipt->discount_amount,
            'amount' => $amount,
        ]);
    }

}