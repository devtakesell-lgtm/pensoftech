<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Lead;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Lead $lead)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Project Inquiry: ' . $this->lead->name)
            ->greeting('Hello Admin,')
            ->line('A new project inquiry has been submitted via the Website Form.')
            ->line('Name: ' . $this->lead->name)
            ->line('Email: ' . $this->lead->email)
            ->line('Service: ' . ($this->lead->lead_type ?? 'N/A'))
            ->line('Budget: ' . ($this->lead->budget ?? 'N/A'))
            ->action('View Lead Details', url('/admin/leads/' . $this->lead->id))
            ->line('Please check the admin panel for full details.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'lead_id' => $this->lead->id,
            'name' => $this->lead->name,
            'message' => 'New project inquiry received from ' . $this->lead->name,
            'url' => url('/admin/leads/' . $this->lead->id),
        ];
    }
}
