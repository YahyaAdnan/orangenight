<div class="p-4 rounded-lg shadow-md">
    <x-filament::section>
        <div class="flex items-center justify-between">
            <!-- Branch Information -->
            <div>
                <h2 class="text-lg font-bold">{{$branch->title}}</h2>
            </div>
            <div>
                <a href="{{$branch->id}}/edit">
                    <x-filament::button color="primary">
                        Edit
                    </x-filament::button>
                </a>
            </div>
        </div>
    </x-filament::section>

    <div class="flex w-full pt-4">
        @foreach ($navigators as $key => $navigator)
            <x-filament::button
                size="md"
                color="gray"
                class="flex-1"
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
                @livewire('InventoryStock', ['model' => $branch])
                @break
            @case(1)
                @livewire('InventoryMovementTable', ['model' => $branch])
                @break
            @default
        @endswitch
    </div>
</div>
