<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Manage Budgets</h2>
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif
    <a class="flex bg-blue-600 w-[5.5rem] justify-between text-sm text-white text-sm my-3 px-4 py-2 rounded hover:bg-blue-700"
        href="{{ route('report') }}" wire:navigate>@include('icons.back-logo') Back</a>
    <div class="space-y-4">
        <div>
            <label for="category_id" class="block text-sm mt-4 font-medium text-gray-700">Category</label>
            <select wire:model="category_id" id="category_id"
                class="mt-1 block p-1 w-xl rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="amount" class="block text-sm mt-4 font-medium text-gray-700">Budget Amount</label>
            <input wire:model="amount" type="number" step="0.01" id="amount"
                class="mt-1 block p-1 w-xl rounded-md border-gray-300 bg-gray-200 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="start_date" class="block text-sm mt-4 font-medium text-gray-700">Start Date</label>
            <input wire:model="start_date" type="date" id="start_date"
                class="mt-1 block p-1 w-xl rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="end_date" class="block text-sm mt-4 font-medium text-gray-700">End Date</label>
            <input wire:model="end_date" type="date" id="end_date"
                class="mt-1 block p-1 w-xl rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Budget</button>
    </div>
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Your Budgets</h3>
        <ul class="m-auto w-lg">
            @foreach ($budgets as $budget)
            <li class="flex justify-between items-center bg-gray-50 p-2 rounded">
                <div><span class="font-bold">{{ $budget->category->name }}:</span> ${{
                    number_format($budget->amount, 2) }} ({{ $budget->start_date }}
                    to {{ $budget->end_date }})</div>
                <div wire:click="delete({{ $budget->id }})" class="mx-1">
                    @include('icons.delete-logo')</div>
            </li>
            @endforeach
        </ul>
    </div>
</div>