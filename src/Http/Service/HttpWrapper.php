<?php

namespace Tuan\Fixably\Http\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Utils;

class HttpWrapper
{
    /**
     * @var string
     */
    private string $apiToken = '';

    /**
     * @var Client
     */
    private $client;

    /**
     * @throws \Exception
     */
    private function getApiToken(): int
    {
        if (!$this->apiToken) {
            $client = $this->getClient();

            try {
                $res = $client->request('POST', 'token', [
                    'multipart' => $this->buildFormData([
                        'Code' => $_ENV['API_CODE']
                    ])
                ]);
            } catch (\Throwable $exception) {
                throw new \Exception('Failed to fetch API token ' . $exception->getMessage());
            }

            if ($res->getStatusCode() !== 200) {
                throw new \Exception('Failed to fetch API token ' . (string)$res->getBody());
            }

            try {
                $resJson = Utils::jsonDecode($res->getBody(), true);
                $this->apiToken = (int)$resJson['token'];
            } catch (\Throwable $exception) {
                throw new \Exception('Failed to fetch API token ' . $exception->getMessage() . ' ' . $res->getBody());
            }
        }

        return $this->apiToken;
    }

    private function getClient(): Client
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => $this->getBaseURI()
            ]);
        }

        return $this->client;
    }

    private function getBaseURI(): string
    {
        return $_ENV['BASE_URI'];
    }

    private function getOptions(): array
    {
        return [
            'headers' => [
                'X-Fixably-Token' => $this->getApiToken(),
            ],
            'multipart' => [],
        ];
    }

    /**
     * @throws \Exception
     */
    public function makeRequest(string $method, string $endpoint, array $data = [], array $pagination = [])
    {
        $client = $this->getClient();
        if (!empty($pagination)) {
            $endpoint .= '?' . \http_build_query($pagination);
        }

        $options = $this->getOptions();
        if ($method === 'POST') {
            if (!empty($data)) {
                $formData = $this->buildFormData($data);
                $options['multipart'] = $formData;
            }
        }

        try {
            $res = $client->request($method, $endpoint, $options);
        } catch (\Throwable $e) {
            throw new \Exception('Failed to fetch data from API ' . $e->getMessage());
        }

        try {
            $resData = Utils::jsonDecode($res->getBody(), true);
        } catch (\Throwable $e) {
            throw new \Exception('Failed to decode response data ' . $e->getMessage() . ' ' . $res->getBody());
        }

        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Failed to get response ' . $resData);
        }

        return $resData;
    }

    private function buildFormData(array $data): array
    {
        $formData = [];
        foreach ($data as $key => $value) {
            $formData[] = [
                'name' => $key,
                'contents' => $value
            ];
        }

        return $formData;
    }

}