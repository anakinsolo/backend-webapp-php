<?php

namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;
use Tuan\Fixably\Model\DataProvider\Iphone as IphoneDataProvider;

class Iphone extends BaseController
{
    public function __construct()
    {
        $this->dataProvider = new IphoneDataProvider();
    }
}