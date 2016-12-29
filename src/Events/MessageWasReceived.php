<?php
namespace NotificationChannels\TextMagic\Events;

use Illuminate\Queue\SerializesModels;

class MessageWasReceived
{
    use SerializesModels;

    public $request;


    /**
     * Create a new event instance.
     *
     * @param $request
     *
     * @internal param
     */
    public function __construct($request)
    {
        $this->request = $request;
    }
}
