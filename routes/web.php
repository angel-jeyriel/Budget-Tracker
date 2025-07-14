<?php

use App\Livewire\AddTransaction;
use App\Livewire\EditTransaction;
use App\Livewire\ManageBudgets;
use App\Livewire\ManageCategories;
use App\Livewire\Report;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/add', AddTransaction::class)->name('add-transaction');
    Route::get('/{transactionId}/edit', EditTransaction::class)->name('edit-transaction');
    Route::get('/report', Report::class)->name('report');
    Route::get('/categories', ManageCategories::class)->name('categories');
    Route::get('/budgets', ManageBudgets::class)->name('budgets');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::post('/notifications/mark-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->middleware('auth')->name('notifications.mark-as-read');

require __DIR__ . '/auth.php';
