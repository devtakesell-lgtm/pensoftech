<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadReceived extends Notification
{
    use Queueable;

    public function __construct(public Lead $lead) {}

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
            ->subject('New lead received: '.$this->lead->name)
            ->greeting('New lead received')
            ->line("{$this->lead->name} submitted a project inquiry.")
            ->line('Email: '.$this->lead->email)
            ->action('View Lead', route('admin.leads.show', $this->lead));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Lead Received',
            'message' => "{$this->lead->name} submitted a new project inquiry.",
            'lead_id' => $this->lead->id,
            'link' => route('admin.leads.show', $this->lead),
        ];
    }
}
