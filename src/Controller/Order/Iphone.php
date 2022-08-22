<?php

namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;

class Iphone extends BaseController
{
    public function execute()
    {
        $result = $this->getIphoneOrderData();
        if (!$result) {
            echo $this->getJsonResponse(['error' => 'Nothing found']);
        }
        echo $this->getJsonResponse($result);
    }

    private function getIphoneOrderData(): array
    {
        $result = [];
        $pageNum = 1;

        try {
            $firstData = $this->httpWrapper->makeRequest(
                'POST',
                'search/devices',
                ['Criteria' => 'iPhone*'],
                ['page' => $pageNum]
            );
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        if (isset($firstData['total'])) {
            while ($pageNum <= $maxPage = $this->getTotalPageNum($firstData['total'])) {
                try {
                    $orderData = $this->httpWrapper->makeRequest(
                        'POST',
                        'search/devices',
                        ['Criteria' => 'iPhone*'],
                        ['page' => $pageNum]
                    );
                } catch (\Exception $exception) {
                    if ($pageNum === $maxPage) {
                        return ['error' => $exception->getMessage()];
                    }

                    $pageNum++;
                    continue;
                }

                if (!isset($orderData['error']) && isset($orderData['results'])) {
                    foreach ($orderData['results'] as $order) {
                        if ($order['technician'] !== null) {
                            $result[] = $order;
                        }
                    }
                }

                $pageNum++;
            }
        }

        return $result;
    }
}