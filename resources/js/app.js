import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm.js';
import AlpineJS from 'alpinejs';
import Chart from 'chart.js/auto';

// Initialize Alpine.js
Alpine.start();

// Notification handler
Livewire.on('open-notifications', () => {
    const messages = @json(auth() -> user() ? auth() -> user() -> unreadNotifications -> pluck('data.message') : []);
    alert('Notifications: ' + (messages.length ? messages.join('\n') : 'No new notifications'));
    if (messages.length) {
        fetch('/notifications/mark-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });
    }
});