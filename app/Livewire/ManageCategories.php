<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManageCategories extends Component
{
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255|unique:categories,name,NULL,id,user_id,' . auth()->id(),
        ]);

        Category::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
        ]);

        $this->reset('name');
        session()->flash('message', 'Category added successfully!');
    }

    public function delete($categoryId)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($categoryId);
        $category->delete();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function render()
    {
        $categories = Category::forUser()->get();
        return view('livewire.manage-categories', compact('categories'));
    }
}
