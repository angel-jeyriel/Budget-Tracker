import Chart from 'chart.js/auto';

window.Chart = Chart;

// Notification handler
Livewire.on('open-notifications', () => {
    const trigger = document.getElementById('notification-trigger');
    const messages = trigger ? JSON.parse(trigger.dataset.messages) : [];

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