<?php

namespace Ethan\LaravelAdmin\Ethan\IM;

class Client
{

    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['message' => 'test mesage']);
    }

    public function sendMessageToUser($message)
    {
        return $this->client->post('http://127.0.0.1:9502', [
            'form_params' => $message
        ]);
    }
}