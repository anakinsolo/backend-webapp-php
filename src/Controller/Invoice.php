<?php

namespace Tuan\Fixably\Controller;

use Tuan\Fixably\Model\InvoiceDataProvider;

class Invoice extends BaseController
{
    public function __construct()
    {
        $this->dataProvider = new InvoiceDataProvider();
    }
}