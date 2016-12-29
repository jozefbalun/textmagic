<?php

namespace NotificationChannels\TextMagic\Events;

use Illuminate\Queue\SerializesModels;
use NotificationChannels\TextMagic\TextMagicMessage;

class MessageWasSent
{
    use SerializesModels;

    public $message;


    /**
     * Create a new event instance.
     *
     * @param TextMagicMessage $message
     */
    public function __construct(TextMagicMessage $message)
    {
        $this->message = $message;
    }
}
