<?php

namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;
use Tuan\Fixably\Model\DataProvider\Order;

class Statistics extends BaseController
{
    public function __construct()
    {
        $this->dataProvider = new Order();
    }
}