<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotificationDropdown extends Component
{
    /**
     * List of notifications.
     *
     * @var array<int, array<string, mixed>>
     */
    public array $notifications = [];

    /**
     * Unread notification count.
     */
    public int $unreadCount = 0;

    /**
     * Create a new component instance.
     *
     * @param  array<int, array<string, mixed>>  $notifications
     */
    public function __construct(array $notifications = [])
    {
        if (empty($notifications)) {
            $this->notifications = [
                [
                    'id' => 1,
                    'title' => 'New Lead Received',
                    'message' => 'Sarah Rahman submitted a new agency quote request.',
                    'time' => '5m ago',
                    'icon' => 'bi-people-fill',
                    'color' => 'purple',
                    'unread' => true,
                    'link' => route('admin.leads'),
                ],
                [
                    'id' => 2,
                    'title' => 'Quote Approved',
                    'message' => 'BrightCo approved Quote #QT-1048 ($12,500).',
                    'time' => '32m ago',
                    'icon' => 'bi-file-earmark-check-fill',
                    'color' => 'green',
                    'unread' => true,
                    'link' => route('admin.quotes'),
                ],
                [
                    'id' => 3,
                    'title' => 'Project Milestone',
                    'message' => 'Nova Labs website redesign marked as 80% completed.',
                    'time' => '2h ago',
                    'icon' => 'bi-kanban-fill',
                    'color' => 'blue',
                    'unread' => true,
                    'link' => route('admin.projects'),
                ],
                [
                    'id' => 4,
                    'title' => 'Client Feedback',
                    'message' => 'Nadia Malik left feedback on Digital Marketing campaign.',
                    'time' => 'Yesterday',
                    'icon' => 'bi-chat-heart-fill',
                    'color' => 'orange',
                    'unread' => false,
                    'link' => route('admin.clients'),
                ],
            ];
        } else {
            $this->notifications = $notifications;
        }

        $this->unreadCount = count(array_filter($this->notifications, fn ($item) => ! empty($item['unread'])));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin.components.notification-dropdown');
    }
}
