<?php

namespace Tuan\Fixably\Controller;

use GuzzleHttp\Utils;
use Tuan\Fixably\Http\Service\HttpWrapper;

class BaseController
{
    protected HttpWrapper $httpWrapper;

    public function __construct(
    ) {
        $this->httpWrapper = new HttpWrapper();
    }

    public function getJsonResponse(array $data): string
    {
        return Utils::jsonEncode($data);
    }

    protected function getTotalPageNum($total): int
    {
        return (int)\ceil($total / 10);
    }
}