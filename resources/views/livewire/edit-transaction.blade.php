<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Add New Transaction</h2>
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif
    <a class="flex bg-blue-600 w-[5.5rem] justify-between text-sm text-white text-sm my-3 px-4 py-2 rounded hover:bg-blue-700"
        href="{{ route('report') }}" wire:navigate>@include('icons.back-logo') Back</a>
    <div class="space-y-4">
        <div class="flex flex-row mt-3 md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1 m-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input wire:model="description" type="text" id="description" value="{{ $transaction->description }}"
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring
                    focus:ring-blue-200">
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex-1 m-2">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input wire:model="amount" type="number" step="0.01" id="amount" value="{{ $transaction->amount }}"
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring
                    focus:ring-blue-200">
                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-row mt-3 md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1 m-2">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select wire:model="category_id" id="category_id"
                    class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="{{ $transaction->category->id }}">{{
                        $transaction->category->name }}</option>
                    @foreach (\App\Models\Category::where('id','<>', $transaction->category->id)->get() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex-1 m-2"> <label for="transaction_date"
                    class="block text-sm font-medium text-gray-700">Date</label>
                <input wire:model="transaction_date" type="date" id="transaction_date"
                    value="{{ $transaction->transaction_date }}" class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring
                    focus:ring-blue-200">
                @error('transaction_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700">Save
        Changes</button>
</div>