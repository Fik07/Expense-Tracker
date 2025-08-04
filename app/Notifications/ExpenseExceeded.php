<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExpenseExceeded extends Notification
{
    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Budget Exceeded!')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have exceeded your budget limit.')
            ->line('Total Expenses: RM ' . number_format($this->amount, 2))
            ->action('View Expenses', url('/expenses'))
            ->line('Please review your spending.');
    }
}
