<x-app-layout>
    <div class="text-center">
        <h2 class="text-2xl font-semibold mb-4">Welcome to Expense Tracker</h2>
        <p class="mb-4">Track your expenses easily and generate insightful reports.</p>
        <div class="space-x-4">
            <a href="{{ route('add-transaction') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Transaction</a>
            <a href="{{ route('report') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">View
                Report</a>
        </div>
    </div>
</x-app-layout>