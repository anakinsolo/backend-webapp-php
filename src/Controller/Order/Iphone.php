<?php

namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;
use Tuan\Fixably\Model\IphoneDataProvider;

class Iphone extends BaseController
{
    public function __construct()
    {
        $this->dataProvider = new IphoneDataProvider();
    }
}