<?php

namespace App\Notifications;

use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;

class FullNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
                ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Haloo')
                ->setBody('Testnotifff'));
    }
}
