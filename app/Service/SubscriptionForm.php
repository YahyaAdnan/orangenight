<?php

namespace App\Service;

use App\Models\Agreement;
use App\Models\Receipt;
use App\Models\Contract;
use App\Models\Delivery;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\Subscription;
use App\Models\SalesMan;
use Filament\Forms\Components;
use Filament\Forms\Get;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;
use Illuminate\Support\Facades\Auth;

class SubscriptionForm
{

    public static function form(?Customer $customer = null)
    {
        try {
            $customers = auth()->user()->salesMan->customers->pluck('full_name', 'id');
        } catch (\Throwable $th) {
            $customers = Customer::pluck('full_name', 'id');
        }

        if($customer)
        {
            $customers = Customer::where('id', $customer)->get();
        }

        return [
            SubscriptionForm::selectSubscription(),
            Components\TextInput::make('address')
                ->required()
                ->maxLength(128)
                ->columnSpanFull(),
            Components\TextInput::make('google_map_url')
                ->label(__('Location URL'))
                ->required()
                ->url()
                ->maxLength(128)
                ->columnSpanFull(),
            SubscriptionForm::selectCustomers($customers)
        ];
    }

    public static function selectSubscription()
    {
        return Components\Section::make()
            ->columns([
                'sm' => 1,
                'md' => 2,
            ])
            ->schema([
                Components\Select::make('subscription_id')
                    ->label(__('subscription'))
                    ->options(Subscription::pluck('title', 'id'))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Components\Select $component) => $component
                        ->getContainer()
                        ->getComponent('contractTile')
                        ->getChildComponentContainer()
                        ->fill()
                    ),
                Components\Grid::make(2)->schema(
                        fn (Get $get) => [
                            Components\TextInput::make('contract')
                                ->label(__('contract'))
                                ->disabled()
                                ->default($get('subscription_id') ? Subscription::find($get('subscription_id'))->contract->title : '')
                                ->hidden(is_null($get('subscription_id')))
                                ->live(),
                            Components\TextArea::make('contract_description')
                                ->label('')
                                ->disabled()
                                ->default($get('subscription_id') ? Subscription::find($get('subscription_id'))->contract->description : '')
                                ->hidden(is_null($get('subscription_id')))
                                ->live()
                                ->columnSpanFull(),

                            SubscriptionForm::getContractTerms($get('subscription_id') ? Subscription::find($get('subscription_id'))->contract : null),
                        ]

                    )
                    ->key('contractTile')
            ]);
    }

    public static function selectCustomers($customers)
    {
        return Components\Section::make()
            ->columns([
                'sm' => 1,
                'md' => 2,
            ])->schema([
                Components\Grid::make([
                    'sm' => 1,
                    'md' => 2,
                ])->schema([
                    Components\Select::make('customer_id')
                        ->label(__('customer'))
                        ->options($customers)
                        ->required()
                        ->searchable(),
                ]),
                SignaturePad::make('customer_signature')
                    ->label(__('customer_signature'))
                    ->hideDownloadButtons(),
                SignaturePad::make('salesman_signature')   
                    ->label(__('salesman_signature'))
                    ->hideDownloadButtons()
            ]);
    }
    public static function getContractTerms(?Contract $contract)
    {
        if($contract == null)
        {
            return Components\Grid::make(1);
        }

        $termsComponents = array();

        foreach ($contract->terms as $key => $term) 
        {
            $termsComponents[] = Components\TextInput::make('term' . $key)
                                    ->label(__('term') . ' ' .$key+1)
                                    ->disabled()
                                    ->default($term->title);

            $termsComponents[] = Components\TextArea::make('contract' . $key)       
                                    ->label('')
                                    ->disabled()
                                    ->default($term->description)
                                    ->columnSpanFull();
        }

        return Components\Grid::make(2)
            ->schema($termsComponents)
            ->columnSpanFull();
    }

    public static function store($data)
    {
        $customer = Customer::find($data['customer_id']);
        $subscription = Subscription::find($data['subscription_id']);

        $receipt = Receipt::create([
            'title' => $customer->full_name . ' (' . now()->format('d-m-Y H:i') . ')',
            'code' => SubscriptionForm::receiptCode(),
            'total_amount' => $subscription->price,
            'discount_amount' => 0,
            'amount' => $subscription->price,
            'paid' => 0,
            'customer_id' => $customer->id,
        ]);

        $agreement = Agreement::create([
            'contract_id' => $subscription->contract_id,
            'customer_id' => $customer->id,
            'user_id' => Auth::id(),
            'customer_signature' => $data['customer_signature'],
            'salesman_signature' => $data['salesman_signature'],
            'status' => 'accepted',
            'agreement_date' => now(),
        ]);

        $customerSub = CustomerSubscription::create([
            'customer_id' => $customer->id,
            'subscription_id' => $subscription->id,
            'agreement_id' => $agreement->id ,
            'active' => 1,
            'address' => $data['address'],
            'duration' => $subscription->duration,
            'receipt_id' => $receipt->id,
        ]);

        SubscriptionForm::createDeliveries($customerSub);

        return $customerSub;
    }

    public static function receiptCode()
    {
        $currentDate = now()->format('d/m/Y');  // e.g. "24/12/2025"

        $receiptCount = Receipt::whereDate('created_at', now()->toDateString())->count();

        return now()->format('ymd') . str_pad($receiptCount, 4, '0', STR_PAD_LEFT);

    }


    public static function createDeliveries(CustomerSubscription $customerSubscription)
    {
        foreach ($customerSubscription->subscription->subscriptionTerms as $key => $term)
        {
            Delivery::create([
                'deliverable_type' => get_class($customerSubscription),
                'deliverable_id' => $customerSubscription->id,  
                'customer_id' => $customerSubscription->customer_id,
                'item_id' => $term->item_id,
                'quantity' => $term->quantity,
                'date' => now()->addDays($term->day),
                'status' => 'pending', // enum('pending','delivered','cancel')
            ]);
        }
    }

}