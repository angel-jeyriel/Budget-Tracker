<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Manage Categories</h2>
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif
    <a class="flex bg-blue-600 w-[5.5rem] justify-between text-sm text-white text-sm my-3 px-4 py-2 rounded hover:bg-blue-700"
        href="{{ route('report') }}" wire:navigate>@include('icons.back-logo') Back</a>
    <div class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
            <input wire:model="name" type="text" id="name"
                class="mt-1 p-1 block w-full border rounded-md border-gray-400 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 mt-4 rounded hover:bg-blue-700">Save
            Category</button>
    </div>
    <div class="mt-6 w-lg m-auto">
        <h3 class="text-lg font-semibold mb-2">Your Categories</h3>
        <ul>
            @forelse ($categories as $category)
            <li class="flex justify-between items-center bg-gray-50 p-2 rounded">
                <span>{{ $category->name }}</span>
                <div wire:click="delete({{ $category->id }})" wire:confirm="Are you sure you want to delete?"
                    class="mx-1">
                    @include('icons.delete-logo')</div>
            </li>
            @empty
            <p class="text-sm text-gray-800">No Categories created yet.</p>
            @endforelse
        </ul>
    </div>
</div>