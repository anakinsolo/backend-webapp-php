<?php

namespace Tuan\Fixably\Controller;

use Tuan\Fixably\Model\DataProvider\Invoice as InvoiceDataProvider;

class Invoice extends BaseController
{
    public function __construct()
    {
        $this->dataProvider = new InvoiceDataProvider();
    }
}