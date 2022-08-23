<?php
namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;

class Save extends BaseController
{
    private $isSampleOrder;

    public function execute()
    {
        $order = $this->createNewOrder();
        if (isset($order['id'])) {
            $res = $this->createNewOrderNote($order['id']);
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

    private function createNewOrder(): array
    {
        if ($this->getIsSampleOrder()) {
            $data = [
                'DeviceManufacturer' => 'Apple',
                'DeviceBrand' => 'Macbook Pro',
                'DeviceType' => 'Laptop',
            ];
        } else {
            $data = [
                'DeviceManufacturer' => $_POST['manu'],
                'DeviceBrand' => $_POST['brand'],
                'DeviceType' => $_POST['type'],
            ];
        }

        try {
            $order = $this->httpWrapper->makeRequest('POST', 'orders/create', $data);
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        return $order;
    }

    private function createNewOrderNote($id)
    {
        $data = [
            'Type' => 'Issue',
            'Description' => $this->getIsSampleOrder() ? 'Broken Screen' : $_POST['desc']
        ];

        $endpoint = 'orders' . '/' . $id . '/' . 'notes/create';
        try {
            $note = $this->httpWrapper->makeRequest('POST', $endpoint, $data);
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        return $note;
    }
}