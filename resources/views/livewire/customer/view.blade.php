<div class="p-4 rounded-lg shadow-md">
    <x-filament::section>
        <div class="flex items-center justify-between">
            <!-- customer Information -->
            <div>
                <h2 class="text-lg font-bold">{{$customer->full_name}}</h2>
                <p>{{__('address')}}: {{$customer->address}}</p>
                <p>
                    {{ __('phone') }}: 
                    @foreach ($customer->phone as $key => $phone)
                        {{$phone['phone']}}@if(!$loop->last),@else. @endif
                    @endforeach
                </p>
                @if($customer->note)
                    <p>{{__('note')}}: {{$customer->note}}</p>
                @endif
            </div>
            <div>
                <a href="{{$customer->id}}/edit">
                    <x-filament::button color="primary">
                        Edit
                    </x-filament::button>
                </a>
            </div>
        </div>
    </x-filament::section>
    <div class="flex w-full pt-4 flex-col sm:flex-row">
        @foreach ($navigators as $key => $navigator)
            <x-filament::button
                size="md"
                color="gray"
                class="flex-1 mb-2 sm:mb-0"
                color="{{$selected_nav == $key ? 'primary' : 'gray'}}"
                wire:click="$set('selected_nav', {{ $key }})"
            >
                {{ $navigator }}
            </x-filament::button>
        @endforeach
    </div>
    
    <div class="pt-4">
        @switch($selected_nav)
            @case(0)
                @livewire('DeliveryTable', ['model' => $customer])
                @break
            @case(1)
                @livewire('InventoryMovementTable', ['model' => $customer])
                @break
            @case(2)
                @livewire('InventoryStock', ['model' => $customer])
                    @break
            @case(3)
                @livewire('SubscriptionTable', ['model' => $customer])
                    @break
            @case(4)
                @livewire('ReceiptTable', ['model' => $customer])
                    @break
            @default
        @endswitch
    </div>
</div>
