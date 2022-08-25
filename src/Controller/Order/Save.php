<?php
namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;
use Tuan\Fixably\Model\DataProvider\Order;

class Save extends BaseController
{
    /** @var bool */
    private bool $isSampleOrder = false;

    public function __construct()
    {
        $this->dataProvider = new Order();
    }

    public function execute()
    {
        $postData = $_POST;
        $order = $this->dataProvider->createNewOrder($postData, $this->getIsSampleOrder());
        if (isset($order['id'])) {
            $res = $this->dataProvider->createNewOrderNote($order['id'], true);
            echo $this->getJsonResponse($res);
        }
    }

    private function getIsSampleOrder()
    {
        if (!$this->isSampleOrder) {
            $this->isSampleOrder = $_POST['is_sample_order'] ?? null;
        }

        return $this->isSampleOrder;
    }
}