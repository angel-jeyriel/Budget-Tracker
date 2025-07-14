<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = ['Food', 'Transport', 'Utilities', 'Entertainment', 'Others'];
        foreach ($categories as $category) {
            Category::create(['user_id' => 1, 'name' => $category]);
        }
    }
}
