<?php

namespace Emmannl\Sms\SmartSms;

use GuzzleHttp\Client;


class SmartSmsSolutions
{
    const base_Url = "https://smartsmssolutions.com/api/json.php";

    private $token;
    private $sender;


    public function __construct(string $token, string $sender)
    {
        $this->token = $token;
        $this->sender = $sender;
    }

    /**
     * Send SMS via Smart Sms Gateway
     * Return true if message was sent successfully, otherwise returns false
     * @param $numbers
     * @param $message
     * @return array
     */
    public function sendMessage($numbers, $message)
    {
        if (is_array($numbers)) {
            $to = implode(',', $numbers);
            $to = rtrim($to);
        } else {
            $to = $numbers;
        }

        $response =  $this->httpRequest(self::base_Url, [
            'sender' => $this->sender,
            'to' => $to,
            'message' => ($message),
            'type' => '0',
            'routing' => '3',
            'token' => $this->token,
        ]);

        $response = json_decode($response, true);

        return [
            'success' => !empty($response['successful']) ? true  : false,
            'response' => $response
        ];
    }

    public function getBalance()
    {
        // TODO
    }

    public function httpRequest($url, array $data = [])
    {
        $client = new Client();

        $response = $client->request('POST', $url, [
            'form_params' => $data
        ]);

        return $response->getBody();
    }

    public function checkBalance()
    {
        //
    }
}
