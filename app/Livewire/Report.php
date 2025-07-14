<?php

namespace App\Livewire;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Notifications\BudgetExceededNotification;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Report extends Component
{
    #[Rule('nullable|date')]
    public $start_date;

    #[Rule('nullable|date|after_or_equal:start_date')]
    public $end_date;

    #[Rule('nullable|exists:categories,id')]
    public $category_id;

    public function mount()
    {
        $this->start_date = now()->subMonth()->toDateString();
        $this->end_date = now()->toDateString();
        $this->category_id = '';
    }

    public function updated($propertyName)
    {
        try {
            $this->validateOnly($propertyName);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return;
        }
    }

    public function resetFilters()
    {
        $this->start_date = now()->subMonth()->toDateString();
        $this->end_date = now()->toDateString();
        $this->category_id = '';
    }

    public function render()
    {
        $query = Transaction::query()->with('category');

        if ($this->start_date) {
            $query->where('transaction_date', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->where('transaction_date', '<=', $this->end_date);
        }

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        $total = $transactions->sum('amount');

        // Chart Data
        $categories = Category::forUser()->get();
        $chartData = [
            'labels' => $categories->pluck('name')->toArray(),
            'data' => $categories->map(function ($category) use ($query) {
                return $query->where('category_id', $category->id)->sum('amount');
            })->toArray(),
        ];

        // Budget Check
        $budgets = Budget::where('user_id', auth()->id())->get();
        foreach ($budgets as $budget) {
            $spent = Transaction::forUser()
                ->where('category_id', $budget->category_id)
                ->whereBetween('transaction_date', [$budget->start_date, $budget->end_date])
                ->sum('amount');
            if ($spent > $budget->amount) {
                auth()->user()->notify(new BudgetExceededNotification($budget, $spent));
            }
        }

        return view('livewire.report', [
            'transactions' => $transactions,
            'categories' => $categories,
            'total' => $total,
            'chartData' => $chartData,
        ]);
    }
}
