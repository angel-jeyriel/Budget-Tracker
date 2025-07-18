<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditTransaction extends Component
{
    public $transactionId;

    #[Rule('required|string|max:255')]
    public $description = '';

    #[Rule('required|numeric|min:0')]
    public $amount = '';

    #[Rule('required|exists:categories,id')]
    public $category_id = '';

    #[Rule('required|date')]
    public $transaction_date = '';

    public function mount($transactionId)
    {
        $this->transactionId = $transactionId;
        $transaction = Transaction::forUser()->findOrFail($transactionId);
        $this->description = $transaction->description;
        $this->amount = $transaction->amount;
        $this->category_id = $transaction->category_id;
        $this->transaction_date = $transaction->transaction_date;
    }

    public function save()
    {
        $validated = $this->validate();

        $transaction = Transaction::forUser()->findOrFail($this->transactionId);
        $transaction->update($validated);

        session()->flash('message', 'Transaction updated successfully!');
        return redirect()->route('report');
    }

    // public function delete()
    // {
    //     $transaction = Transaction::forUser()->findOrFail($this->transactionId);
    //     $transaction->delete();
    //     session()->flash('message', 'Transaction deleted successfully!');
    //     return redirect()->route('report');
    // }

    public function render()
    {
        return view('livewire.edit-transaction', [
            'categories' => Category::forUser()->get(),
            'transaction' => Transaction::forUser()->findOrFail($this->transactionId),
        ]);
    }
}
