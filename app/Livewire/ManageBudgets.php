<?php

namespace App\Livewire;

use App\Models\Budget;
use App\Models\Category;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManageBudgets extends Component
{
    #[Rule('required|exists:categories,id')]
    public $category_id;

    #[Rule('required|numeric|min:0')]
    public $amount = '';

    #[Rule('required|date')]
    public $start_date;

    #[Rule('required|date|after_or_equal:start_date')]
    public $end_date;

    public function save()
    {
        $validated = $this->validate();
        $validated['user_id'] = auth()->id();

        Budget::create($validated);

        $this->reset(['category_id', 'amount', 'start_date', 'end_date']);
        session()->flash('message', 'Budget added successfully!');
    }

    public function delete($budgetId)
    {
        $budget = Budget::where('user_id', auth()->id())->findOrFail($budgetId);
        $budget->delete();
        session()->flash('message', 'Budget deleted successfully!');
    }

    public function render()
    {
        return view('livewire.manage-budgets', [
            'categories' => Category::forUser()->get(),
            'budgets' => Budget::where('user_id', auth()->id())->with('category')->get(),
        ]);
    }
}
