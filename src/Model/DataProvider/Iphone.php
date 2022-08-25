<?php
namespace Tuan\Fixably\Model\DataProvider;

class Iphone extends AbstractDataProvider
{
    public function getData(): array
    {
        $result = $this->getIphoneOrderData();
        if (!$result) {
            return ['error' => 'Nothing found'];
        }

        return $result;
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