<?php

namespace NotificationChannels\TextMagic\Exceptions;

use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends \Exception
{

    public static function serviceRespondedWithAnError(ClientException $exception)
    {
        $statusCode = $exception->getResponse()->getStatusCode();
        $description = 'no description given';
        if ($result = json_decode($exception->getResponse()->getBody())) {
            $description = $result->message ?: $description;
        }

        return new static("TextMagic responded with an error `{$statusCode} - {$description}`");
    }


    public static function textMagicApiKeyNotProvided()
    {
        return new static('You must provide your TextMagic api key and username to make any API requests.');
    }


    public static function couldNotCommunicateWithTextMagic()
    {
        return new static('The communication with TextMagic failed.');
    }


    public static function phoneNotProvided()
    {
        return new static('TextMagic notification phone was not provided. Please refer usage docs.');
    }
}
