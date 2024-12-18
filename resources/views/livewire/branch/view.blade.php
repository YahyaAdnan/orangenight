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
    
    <div class="flex space-x-4 my-4">
        <!-- Tab 1 -->
        <button 
            class="tab-btn px-4 py-2 rounded bg-blue-500 text-white" 
            data-tab="tab-stock"
        >
            Inventory Stock
        </button>
        <!-- Tab 2 -->
        <button 
            class="tab-btn px-4 py-2 rounded bg-gray-200" 
            data-tab="tab-movement"
        >
            Inventory Movement
        </button>
    </div>

    <!-- Tab Content -->
    <div id="tab-stock" class="tab-content">
        @livewire('InventoryStock', ['model' => $branch])
    </div>
    <div id="tab-movement" class="tab-content hidden">
        @livewire('InventoryMovementTable', ['model' => $branch])
    </div>
</div>
