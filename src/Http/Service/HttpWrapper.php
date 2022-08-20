<?php

namespace Tuan\Fixably\Http\Service;
use GuzzleHttp\Client;

class HttpWrapper
{
    private $apiToken;

    private $client;

    public function getApiToken() 
    {
        if (!$this->apiToken) {
            $client = $this->getClient();
            $res = $client->request('POST', 'token', [
                'multipart' => [
                    [
                        'name' => 'Code',
                        'contents' => '1234',
                        'headers' => $this->getRequestHeaders(),
                    ]
                ]
            ]);
            $this->apiToken = $res->getBody();
            var_dump((string)$this->apiToken);die;
        }

        return $this->apiToken;
    }

    private function getClient() 
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => $this->getBaseURI()
            ]);
        }

        return $this->client;
    }

    private function getBaseURI() 
    {
        return 'https://careers-api.fixably.com/';
    }

    private function getRequestHeaders() 
    {
        return [
            'Content-Type' => 'multipart/form-data',
        ];
    }

    private function getOptions()
    {
        $header = $this->getRequestHeaders();
        $header['X-Fixably-Token'] = $this->getApiToken();

        return [
            'headers' => $header,
            'multipart' => [],
        ];
    }

    public function get($endpoint)
    {
        $client = $this->getClient();

        $response = $client->request('GET', $endpoint, $this->getOptions());
        return $response->getBody();
    }

    public function post($endpoint, $data)
    {
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_depth', -1);
        $options = $this->getOptions();
        $options['multipart'] = $data;
        var_dump($options);
        $client = $this->getClient();

        $response = $client->request('POST', $endpoint, $options);
        return (string)$response->getBody();
    }

}