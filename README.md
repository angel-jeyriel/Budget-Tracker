Expense Tracker

A web-based application for managing personal expenses, built with Laravel 12, Livewire, Tailwind CSS, Alpine.js, and Chart.js. It allows users to track transactions, set budgets, manage categories, and visualize expenses with a responsive bar chart. Features include user authentication, recurring expense scheduling, budget notifications, and a responsive UI.

Features





User Authentication: Register, login, and logout using Laravel Breeze.



Transaction Management: Add, edit, and delete transactions with details like description, amount, category, and date.



Recurring Expenses: Schedule daily, weekly, or monthly recurring expenses with a toggleable frequency dropdown.



Budget Tracking: Set budgets per category and receive notifications when exceeded.



Expense Reports: Filter transactions by date and category, with a Chart.js bar chart visualizing expenses by category.



Responsive Design: Mobile-friendly navigation with a hamburger menu and smooth UI animations via Alpine.js.

Prerequisites





PHP: ^8.2



Composer: ^2.7



Node.js: ^20.x



npm: ^10.x



MySQL or another database supported by Laravel



Git: For cloning the repository

Installation





Clone the Repository:

git clone https://github.com/your-username/expense-tracker.git
cd expense-tracker



Install PHP Dependencies:

composer install



Install JavaScript Dependencies:

npm install

If you encounter an ERESOLVE dependency conflict (e.g., between vite and @tailwindcss/vite), try:

npm install --legacy-peer-deps

Or ensure package.json uses compatible versions:

{
  "devDependencies": {
    "@tailwindcss/vite": "^4.0.7",
    "autoprefixer": "^10.4.7",
    "postcss": "^8.4.14",
    "tailwindcss": "^3.4.3",
    "vite": "^5.4.8",
    "laravel-vite-plugin": "^1.0.5"
  },
  "dependencies": {
    "alpinejs": "^3.14.0",
    "chart.js": "^4.4.0"
  }
}



Set Up Environment:





Copy .env.example to .env:

cp .env.example .env



Update .env with your database credentials and queue configuration:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=root
DB_PASSWORD=
QUEUE_CONNECTION=database



Generate an application key:

php artisan key:generate



Run Migrations and Seeders:

php artisan migrate
php artisan db:seed --class=CategorySeeder



Compile Assets:

npm run build



Start the Queue Worker (for recurring expenses):

php artisan queue:work



Serve the Application:

php artisan serve
npm run dev

Access the app at http://localhost:8000.

Project Structure





app/Http/Livewire/: Contains Livewire components (AddTransaction.php, Report.php).



resources/views/livewire/: Blade views for Livewire components (add-transaction.blade.php, report.blade.php).



resources/views/layouts/app.blade.php: Main layout with responsive navigation.



resources/js/app.js: JavaScript for Alpine.js, Chart.js, and Livewire event handling.



resources/css/app.css: Tailwind CSS styles.



tailwind.config.js: Tailwind configuration with content paths and safelist for Livewire components.

Usage





Register/Login: Create an account or log in at /register or /login.



Add Transaction (/add-transaction):





Enter description, amount, category, and date.



Toggle "Recurring Expense" to show/hide the frequency dropdown (daily, weekly, monthly).



Save to store the transaction and optional recurring expense.



View Report (/report):





Filter transactions by date range and category.



View a bar chart of expenses by category using Chart.js.



See budget details and spending summaries.



Manage Categories (/categories): Add or edit expense categories.



Manage Budgets (/budgets): Set budgets for categories with start/end dates.



Notifications: Click "Notifications" in the header to view budget exceedance alerts.

Troubleshooting





npm Dependency Conflict:





If npm install fails with ERESOLVE, check package.json versions or use:

npm install --legacy-peer-deps



Verify vite@5.4.8 and @tailwindcss/vite@4.0.7 are installed:

npm list vite @tailwindcss/vite



Empty resources/js/app.js or public/build/assets/app-*.js:





Ensure resources/js/app.js contains:

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm.js';
import AlpineJS from 'alpinejs';
import Chart from 'chart.js/auto';
Alpine.start();



Run npm run build and check public/build/assets/app-*.js for Alpine.start and Chart.



Check browser console (F12) for errors.



Non-Responsive Menu:





Verify app.blade.php includes Alpine.js and responsive classes (md:hidden, flex-col).



Test in mobile viewport via browser developer tools.



Ensure tailwind.config.js includes all necessary classes:

safelist: [
  'bg-white', 'p-6', 'rounded-lg', 'text-red-500', 'bg-blue-600', 'hover:bg-blue-700',
  'grid-cols-1', 'md:grid-cols-2', 'md:grid-cols-3', 'focus:ring-opacity-50',
  'py-2', 'px-3', 'space-y-6', 'gap-4', 'mr-2', 'rounded', 'border-gray-300',
  'focus:ring-blue-200', 'focus:border-blue-300', 'bg-green-100', 'text-green-700',
  'mb-4', 'inline-block', 'text-sm', 'text-white', 'md:hidden', 'flex-col', 'absolute',
  'top-16', 'right-4', 'bg-gray-50', 'p-4', 'text-gray-500', 'hover:bg-gray-50',
  'text-blue-600', 'text-red-600', 'ml-2', 'font-bold', 'text-xs', 'uppercase',
  'tracking-wider', 'divide-y', 'divide-gray-200', 'bg-gray-500', 'hover:bg-gray-600'
]



Chart.js Not Rendering:





Ensure chart.js is in package.json and app.js imports Chart.



Check browser console for “Chart is not defined.”



Verify <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script> in app.blade.php.



Tailwind CSS Not Working:





Run npm run build and check public/build/assets/app.css for classes like .bg-white.



If classes are missing, ensure tailwind.config.js includes:

content: [
  './resources/**/*.blade.php',
  './resources/**/*.js',
  './resources/**/*.vue',
  './app/Http/Livewire/**/*.php',
]



Clear caches:

php artisan view:clear
php artisan cache:clear

Contributing





Fork the repository.



Create a feature branch (git checkout -b feature/your-feature).



Commit changes (git commit -m 'Add your feature').



Push to the branch (git push origin feature/your-feature).



Open a pull request.

License

This project is licensed under the MIT License.
