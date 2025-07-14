<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\RecurringExpense;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddTransaction extends Component
{
    #[Rule('required|string|max:255')]
    public $description = '';

    #[Rule('required|numeric|min:0')]
    public $amount = '';

    #[Rule('required|exists:categories,id')]
    public $category_id = '';

    #[Rule('required|date')]
    public $transaction_date = '';

    public $is_recurring = false;

    #[Rule('required_if:is_recurring,true|in:daily,weekly,monthly')]
    public $frequency = '';

    public function save()
    {
        $validated = $this->validate();
        $validated['user_id'] = auth()->id();

        Transaction::create($validated);

        if ($this->is_recurring) {
            RecurringExpense::create([
                'user_id' => auth()->id(),
                'description' => $this->description,
                'amount' => $this->amount,
                'category_id' => $this->category_id,
                'frequency' => $this->frequency,
                'next_occurrence' => $this->calculateNextOccurrence($this->transaction_date, $this->frequency),
            ]);
        }

        $this->reset(['description', 'amount', 'category_id', 'transaction_date', 'is_recurring', 'frequency']);
        session()->flash('message', 'Transaction added successfully!');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($propertyName === 'is_recurring' && !$this->is_recurring) {
            $this->frequency = '';
        }
    }

    private function calculateNextOccurrence($date, $frequency)
    {
        $date = Carbon::parse($date);
        return match ($frequency) {
            'daily' => $date->addDay(),
            'weekly' => $date->addWeek(),
            'monthly' => $date->addMonth(),
        };
    }

    public function render()
    {
        $categories = Category::forUser()->get();
        return view('livewire.add-transaction', compact('categories'));
    }
}
