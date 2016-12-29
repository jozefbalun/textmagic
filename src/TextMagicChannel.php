<?php

namespace NotificationChannels\TextMagic;

use NotificationChannels\TextMagic\Exceptions\CouldNotSendNotification;
use NotificationChannels\TextMagic\Events\MessageWasSent;
use Illuminate\Notifications\Notification;

class TextMagicChannel
{

    /**
     * @var TextMagic
     */
    protected $textMagic;


    /**
     * Channel constructor.
     *
     * @param TextMagic $textMagic
     *
     * @internal param TextMagic $textMagic
     */
    public function __construct(TextMagic $textMagic)
    {
        $this->textMagic = $textMagic;
    }


    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\TextMagic\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTextMagic($notifiable);

        if (is_string($message)) {
            $message = TextMagicMessage::create($message);
        }

        if ($message->toNotGiven()) {
            if (! $to = $notifiable->routeNotificationFor('textmagic')) {
                throw CouldNotSendNotification::phoneNotProvided();
            }
            $message->to([$to]);
        }

        $params = $message->toArray();
        $this->textMagic->sendMessage($params);
        event(new MessageWasSent($message));
    }
}
