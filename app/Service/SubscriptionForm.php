<?php

namespace App\Service;

use App\Models\Agreement;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\SalesMan;
use Filament\Forms\Components;
use Filament\Forms\Get;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;

class SubscriptionForm
{

    public static function form()
    {
        $customers = Customer::pluck('full_name', 'id'); // TODO: make it show for sales man only his customers.

        return [
            SubscriptionForm::selectSubscription(),
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
                    ->label('subscription')
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
                                ->label('contract')
                                ->disabled()
                                ->default($get('subscription_id') ? Subscription::find($get('subscription_id'))->contract->title : '')
                                ->hidden(is_null($get('subscription_id')))
                                ->live(),
                            Components\TextArea::make('contract')
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
                        ->options($customers)
                        ->required()
                        ->searchable(),
                ]),
                SignaturePad::make('customer_signature')
                    ->hideDownloadButtons(),
                SignaturePad::make('salesman_signature')
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
                                    ->label('term ' . $key+1)
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
}