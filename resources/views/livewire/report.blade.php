<div class="bg-white p-6 rounded-lg shadow-md">
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif
    <a class="flex bg-blue-600 w-[10.5rem] justify-between text-sm text-white mr-auto content-end my-3 px-4 py-2 rounded hover:bg-blue-700"
        href="{{ route('add-transaction') }}" wire:navigate>@include('icons.add-logo') New Transaction</a>
    <h2 class="text-xl font-semibold mb-4">Expense Report</h2>
    <div class="mb-6 space-y-4">
        <div class="flex flex-row md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input wire:model.live="start_date" type="date" id="start_date"
                    class="mt-1 block p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input wire:model.live="end_date" type="date" id="end_date"
                    class="mt-1 block p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex-1">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select wire:model.live="category_id" id="category_id"
                    class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex justify-end">
            <button wire:click="resetFilters"
                class="bg-gray-700 text-white text-sm px-3 py-1 rounded hover:bg-gray-800">Reset
                Filters</button>
        </div>
    </div>

    {{-- Chart --}}
    <div class="mb-6">
        <canvas id="expenseChart" class="w-full h-64"></canvas>
        <script>
            document.addEventListener('livewire:init', () => {
                let chartInstance = null;
                Livewire.on('updateChart', ({ labels, data }) => {
                    console.log('Chart Data:', { labels, data });
                    const ctx = document.getElementById('expenseChart').getContext('2d');
                    if (chartInstance) {
                        chartInstance.destroy();
                    }
                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Categories',
                                data: data,
                                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                borderColor: 'rgba(59, 130, 246, 1.0)',
                                borderWidth: 1,
                            }],
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                },
                            },
                        },
                    });
                });
                Livewire.dispatch('updateChart', { labels: @json($chartData['labels']), data: @json($chartData['data']) });
            });
        </script>
    </div>

    {{-- Budget Information --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Budgets</h3>
        <div class="flex">
            @forelse (\App\Models\Budget::where('user_id', auth()->id())->with('category')->get() as $budget)
            <div class="bg-gray-50 p-4 rounded m-2">
                <p><strong>Category:</strong> <span class="uppercase">{{ $budget->category->name }}</span></p>
                <p><strong>Budget:</strong> ${{ number_format($budget->amount, 2) }}</p>
                <p><strong>Period:</strong> {{ $budget->start_date }} to {{ $budget->end_date }}</p>
                <p><strong>Spent:</strong> ${{ number_format(\App\Models\Transaction::forUser()->where('category_id',
                    $budget->category_id)->whereBetween('transaction_date', [$budget->start_date,
                    $budget->end_date])->sum('amount'), 2) }}</p>
            </div>
            @empty
            <p class="text-sm">No budget created yet. <a href="{{route('budgets')}}">Create new Budget</a></p>
            @endforelse
        </div>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading wire:target="start_date, end_date, category_id" class="text-center text-gray-500 mb-4">
        <svg class="animate-spin h-5 w-5 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        Loading...
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($transactions as $transaction)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-4 text-sm text-gray-900">{{ $transaction->description }}</td>
                    <td class="py-4 px-4 text-sm text-gray-900">${{ number_format($transaction->amount, 2) }}</td>
                    <td class="py-4 px-4 text-sm text-gray-900">{{ $transaction->category->name }}</td>
                    <td class="py-4 px-4 text-sm text-gray-900">{{ $transaction->transaction_date }}</td>
                    <td class="flex py-4 px-4 text-sm text-gray-900">
                        <a href="{{ route('edit-transaction', $transaction->id) }}"
                            class="mx-1">@include('icons.edit-logo')</a>
                        <div wire:click="delete({{ $transaction->id }})" wire:confirm="Are you sure you want to delete?"
                            class="mx-1 cursor-pointer">
                            @include('icons.delete-logo')</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 px-4 text-center text-sm text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50">
                    <td class="py-3 px-4 text-sm font-bold text-gray-900">Total</td>
                    <td class="py-3 px-4 text-sm font-bold text-gray-900">${{ number_format($total, 2) }}</td>
                    <td class="py-3 px-4"></td>
                    <td class="py-3 px-4"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>