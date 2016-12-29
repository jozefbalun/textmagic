<?php
namespace NotificationChannels\TextMagic;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use NotificationChannels\TextMagic\Events\MessageWasReceived;
use NotificationChannels\TextMagic\Exceptions\CouldNotSendNotification;

class TextMagic
{

    const API_URL = 'https://rest.textmagic.com/api/v2';

    /** @var Client */
    protected $client;

    /** @var string */
    protected $token;

    /** @var string */
    protected $username;


    /**
     * @param Client $client
     * @param string $token
     * @param null   $username
     */
    public function __construct(Client $client, $token = null, $username = null)
    {
        $this->client = $client;
        $this->token = $token;
        $this->username = $username;
    }


    public function sendMessage($params)
    {
        return $this->sendRequest('messages', $params);
    }


    /**
     * @param $action
     * @param $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws CouldNotSendNotification
     * @internal param TextMagicMessage $message
     * @internal param string $recipient
     *
     */
    public function sendRequest($action, $params)
    {
        if (empty($this->token) || empty($this->username)) {
            throw CouldNotSendNotification::textMagicApiKeyNotProvided();
        }

        try {
            return $this->client->request('POST', self::API_URL . '/' . $action, [
                'form_params' => $params,
                'headers' => [
                    "X-TM-Username" => $this->username,
                    "X-TM-Key" => $this->token,
                ],
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithTextMagic();
        }
    }


    public function callback(Request $request)
    {
        event(new MessageWasReceived($request->all()));

        return $request->all();
    }
}
