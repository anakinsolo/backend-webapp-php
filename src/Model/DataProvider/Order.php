<?php

namespace Tuan\Fixably\Model\DataProvider;

class Order extends AbstractDataProvider
{

    public function getData(): array
    {
        $statuses = $this->getStatusData();
        if (isset($statuses['error'])) {
            return $statuses;
        }

        if (empty($statuses)) {
            return ['error' => 'Failed to get order statuses'];
        }

        $result = $this->getOrderData($statuses);
        return $this->sortResult($result);
    }

    private function sortResult(array $result): array
    {
        \usort($result, function(array $firstEle, array $secondEle) {
            if ($firstEle['count'] === $secondEle['count']) {
                return 0;
            }

            return ($firstEle['count'] > $secondEle['count']) ? -1 : 1;
        });

        return $result;
    }


    private function getOrderData(array $result): array
    {
        $pageNum = 1;

        try {
            $firstOrderData = $this->httpWrapper->makeRequest('GET', 'orders', [], ['page' => $pageNum]);
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        if ($firstOrderData['total']) {
            while ($pageNum <= $maxPage = $this->getTotalPageNum((int)$firstOrderData['total'])) {
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

        return \array_values($result);
    }

    private function getStatusData(): array
    {
        $result = [];

        try {
            $statuses = $this->httpWrapper->makeRequest('GET', 'statuses', [], []);
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        foreach ($statuses as $status) {
            $result[$status['id']] = [
                'id' => $status['id'],
                'description' => $status['description'],
                'count' => 0,
            ];
        }

        return $result;
    }

    public function createNewOrder(array $postData, $isSample = false): array
    {
        if (empty($postData) && !$isSample) {
            return ['error' => 'Order data required'];
        }

        if ($isSample) {
            $data = [
                'DeviceManufacturer' => 'Apple',
                'DeviceBrand' => 'Macbook Pro',
                'DeviceType' => 'Laptop',
            ];
        } else {
            $data = [
                'DeviceManufacturer' => $postData['manu'],
                'DeviceBrand' => $postData['brand'],
                'DeviceType' => $postData['type'],
            ];
        }

        try {
            $order = $this->httpWrapper->makeRequest('POST', 'orders/create', $data);
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        return $order;
    }

    public function createNewOrderNote(int $id, $isSample = false): array
    {
        $data = [
            'Type' => 'Issue',
            'Description' => $isSample ? 'Broken Screen' : $_POST['desc']
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