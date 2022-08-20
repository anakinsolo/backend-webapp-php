<?php

namespace Tuan\Fixably\Controller\Order;
use Tuan\Fixably\Controller\BaseController;
use Tuan\Fixably\Http\Service\HttpWrapper;

class Statistics extends BaseController
{
    private HttpWrapper $httpWrapper;

    public function __construct(
    ) {
        $this->httpWrapper = new HttpWrapper();
    }

    public function execute()
    {
        $formData = $this->buildFormData(['Criteria' => '*']);
        var_dump($formData);
        var_dump($this->httpWrapper->post('/search/statuses', $formData));
    }
}