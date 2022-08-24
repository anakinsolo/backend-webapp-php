<?php

namespace Tuan\Fixably\Controller;

use GuzzleHttp\Utils;
use Tuan\Fixably\Model\AbstractDataProvider;

abstract class BaseController
{
    protected AbstractDataProvider $dataProvider;

    public function getJsonResponse(array $data): string
    {
        return Utils::jsonEncode($data);
    }

    public function execute()
    {
        echo $this->getJsonResponse($this->dataProvider->getData());
    }
}