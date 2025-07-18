# Expense Tracker

A web-based application for tracking personal expenses, built with **Laravel 12**, **Livewire**, **Tailwind CSS**, **Alpine.js**, and **Chart.js**. Features include adding and editing transactions, managing categories and budgets, visualizing expenses with charts, and handling recurring expenses with automated notifications.

## Features
- **User Authentication**: Secure login and registration using Laravel Breeze.
- **Transaction Management**: Add, edit, and delete transactions with details like description, amount, category, and date.
- **Recurring Expenses**: Support for daily, weekly, or monthly recurring expenses with automated processing.
- **Categories and Budgets**: Manage expense categories and set budgets with notifications for exceedances.
- **Responsive Report Page**: Filter transactions by date and category, with a Chart.js bar chart visualizing expenses by category.
- **Responsive UI**: Mobile-friendly navigation with a collapsible menu bar using Alpine.js.

## Tech Stack
- **Backend**: Laravel 12, Livewire
- **Frontend**: Tailwind CSS, Alpine.js, Chart.js
- **Database**: MySQL (configurable via `.env`)
- **Queue**: Laravel Queue for processing recurring expenses
- **Build Tool**: Vite

## Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18.x
- npm >= 9.x
- MySQL or another supported database
- Git
