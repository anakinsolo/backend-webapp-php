<?php
namespace Tuan\Fixably\Model;

class InvoiceDataProvider extends AbstractDataProvider
{
    public function getData(): array
    {
        $res = $this->getReportData();
        return $this->getChanges($res);
    }

    private function getReportData(): array
    {
        $result = [];
        foreach ($this->getWeekDates() as $startDate => $endDate) {
            $pageNum = 1;
            $totalInvoices = 0;
            $totalInvoicedAmount = 0;

            try {
                $firstData = $this->httpWrapper->makeRequest(
                    'POST',
                    'report' . '/' . $startDate . '/' . $endDate,
                    [],
                    ['page' => $pageNum]
                );
            } catch (\Exception $exception) {
                $result[$startDate . ' - ' . $endDate] = [
                    'error' => $exception->getMessage()
                ];
                continue;
            }


            if (isset($firstData['total'])) {
                $totalInvoices = $firstData['total'];
                while ($pageNum <= $maxPage = $this->getTotalPageNum($firstData['total'])) {
                    try {
                        $invoiceData = $this->httpWrapper->makeRequest(
                            'POST',
                            'report' . '/' . $startDate . '/' . $endDate,
                            [],
                            ['page' => $pageNum]
                        );
                    } catch (\Exception $exception) {
                        if ($pageNum === $maxPage) {
                            $result[$startDate . ' - ' . $endDate] = [
                                'error' => $exception->getMessage()
                            ];
                            break;
                        }

                        $pageNum++;
                        continue;
                    }

                    if (!isset($invoiceData['error']) && isset($invoiceData['results'])) {
                        foreach ($invoiceData['results'] as $invoice) {
                            $totalInvoicedAmount += $invoice['amount'];
                        }
                    }

                    $pageNum++;
                }
            }

            $result[] = [
                'week' => $startDate . ' - ' . $endDate,
                'total_invoices' => $totalInvoices,
                'total_invoiced_amount' => $totalInvoicedAmount,
            ];
        }

        return $result;
    }

    private function getChanges($data): array
    {
        $result = [];
        $result[0] = $data[0];
        $maxCount = \count($data);
        for ($i = 0; $i < $maxCount; $i++) {
            $result[$i] = [
                'week' => $data[$i]['week'],
                'total_invoices' => $data[$i]['total_invoices'],
                'total_invoiced_amount' => $data[$i]['total_invoiced_amount'],
            ];

            if ($i === 0) {
                continue;
            }

            $currWeek = $data[$i];
            $prevWeek = $data[$i - 1];
            $invoicesChanged = $this->getInvoiceChanged($currWeek, $prevWeek);
            $result[$i]['total_invoices_changed'] = $invoicesChanged . '%';
            $invoiceAmountChanged = $this->getInvoiceAmountChanged($currWeek, $prevWeek);
            $result[$i]['total_invoiced_amount_changed'] = $invoiceAmountChanged . '%';
        }

        return $result;
    }

    private function getInvoiceChanged($curr, $prev): float
    {
        if ($curr['total_invoices'] > $prev['total_invoices']) {
            $totalInvoicesChanged = ($curr['total_invoices'] - $prev['total_invoices']) / $curr['total_invoices'] * 100;
        } elseif ($curr['total_invoices'] < $prev['total_invoices']) {
            $totalInvoicesChanged = -(($prev['total_invoices'] - $curr['total_invoices']) / $prev['total_invoices'] * 100);
        } else {
            $totalInvoicesChanged = 0.00;
        }

        return \round($totalInvoicesChanged, 1);
    }

    private function getInvoiceAmountChanged($curr, $prev): float
    {
        if ($curr['total_invoiced_amount'] > $prev['total_invoiced_amount']) {
            $totalInvoicesChanged = ($curr['total_invoiced_amount'] - $prev['total_invoiced_amount']) / $curr['total_invoiced_amount'] * 100;
        } elseif ($curr['total_invoiced_amount'] < $prev['total_invoiced_amount']) {
            $totalInvoicesChanged = -(($prev['total_invoiced_amount'] - $curr['total_invoiced_amount']) / $prev['total_invoiced_amount'] * 100);
        } else {
            $totalInvoicesChanged = 0.00;
        }

        return \round($totalInvoicesChanged, 1);
    }

    private function getWeekDates(): array
    {
        return [
            '2020-11-02' => '2020-11-08',
            '2020-11-09' => '2020-11-15',
            '2020-11-16' => '2020-11-22',
            '2020-11-23' => '2020-11-29',
        ];
    }
}