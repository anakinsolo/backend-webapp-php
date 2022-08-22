<?php

namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;

class Statistics extends BaseController
{
    public function execute()
    {
        $statuses = $this->getStatusData();
        if (isset($statuses['error'])) {
            return $this->getJsonResponse($statuses);
        }

        if (empty($statuses)) {
            return $this->getJsonResponse(['error' => 'Failed to get order statuses']);
        }

        $orderData = $this->getOrderData($statuses);
        echo $this->getJsonResponse($orderData);
    }

    private function getOrderData($result): array
    {
        $pageNum = 1;

        try {
            $firstOrderData = $this->httpWrapper->makeRequest('GET', 'orders', [], ['page' => $pageNum]);
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        if ($firstOrderData['total']) {
            while ($pageNum <= $maxPage = $this->getTotalPageNum($firstOrderData['total'])) {
                try {
                    $orderData = $this->httpWrapper->makeRequest('GET', 'orders', [], ['page' => $pageNum]);
                } catch (\Exception $exception) {
                    if ($pageNum === $maxPage) {
                        return ['error' => $exception->getMessage()];
                    }

                    $pageNum++;
                    continue;
                }

                if (!isset($orderData['error']) && isset($orderData['results'])) {
                    foreach ($orderData['results'] as $order) {
                        $result[$order['status']]['count'] += 1;
                    }
                }

                $pageNum += 1;
            }
        }

        return $result;
    }

    private function getStatusData(): array
    {
        $result = [];

        try {
            $statuses = $this->httpWrapper->makeRequest('GET', 'statuses', [], []);
        } catch (\Exception $exception) {
            return ['error' => $exception];
        }

        foreach ($statuses as $status) {
            $result[$status['id']] = [
                'description' => $status['description'],
                'count' => 0,
            ];
        }

        return $result;
    }
}