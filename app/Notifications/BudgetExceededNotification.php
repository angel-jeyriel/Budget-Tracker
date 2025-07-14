<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BudgetExceededNotification extends Notification
{
    use Queueable;

    protected $budget;
    protected $spent;
    /**
     * Create a new notification instance.
     */
    public function __construct($budget, $spent)
    {
        $this->budget = $budget;
        $this->spent = $spent;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "You have exceeded your budget of {$this->budget->amount} for {$this->budget->category->name}. Spent: {$this->spent}.",
            'category_id' => $this->budget->category_id,
        ];
    }

    /*
        * Get the notification's delivery channels.
        *
        * @return array<int, string>
        public function via(object $notifiable): array
        {
            return ['mail'];
        }

        
        * Get the mail representation of the notification.
        public function toMail(object $notifiable): MailMessage
        {
            return (new MailMessage)
                ->line('The introduction to the notification.')
                ->action('Notification Action', url('/'))
                ->line('Thank you for using our application!');
        }
    */

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
