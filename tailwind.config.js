/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Http/Livewire/**/*.php', // Include Livewire component classes
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}