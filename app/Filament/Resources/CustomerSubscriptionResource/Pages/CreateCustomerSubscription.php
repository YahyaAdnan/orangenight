<?php

namespace App\Filament\Resources\CustomerSubscriptionResource\Pages;

use App\Service\SubscriptionForm;
use App\Filament\Resources\CustomerSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCustomerSubscription extends CreateRecord
{
    protected static string $resource = CustomerSubscriptionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return SubscriptionForm::store($data);
    }
}
