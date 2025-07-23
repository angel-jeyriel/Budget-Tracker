<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Add New Transaction</h2>
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif
    <a class="flex bg-blue-600 w-[5.5rem] justify-between text-sm text-white text-sm my-3 px-4 py-2 rounded hover:bg-blue-700"
        href="{{ route('report') }}" wire:navigate>@include('icons.back-logo') Back</a>
    @if (count($categories) > 0)
    <div class="space-y-4">
        <div class="flex flex-row mt-3 md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1 m-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input wire:model="description" type="text" id="description" value=""
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex-1 m-2">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input wire:model="amount" type="number" step="0.01" id="amount" value=""
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-row mt-3 md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1 m-2">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select wire:model="category_id" id="category_id"
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex-1 m-2">
                <label for="transaction_date" class="block text-sm font-medium text-gray-700">Date</label>
                <input wire:model="transaction_date" type="date" id="transaction_date" value=""
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                @error('transaction_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-row mt-3 md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1">
                <label class="flex items-center">
                    <input wire:model.live="is_recurring" type="checkbox" class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Recurring Expense</span>
                </label>
            </div>
            <div class="flex-1" x-data="{ show: @entangle('is_recurring').live }" x-show="show" x-transition>
                <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency</label>
                <select wire:model.live="frequency" id="frequency"
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Select frequency</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
                @error('frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700">Save
        Transaction</button>
    @else
    <div class="mt-2 flex justify-center">
        <p class="text-lg">Categories are necessary for adding new Transactions. <a href="{{route('categories')}}"
                class="border rounded-md p-1">Create a new Category.</a>
        </p>
    </div>
    @endif
</div>