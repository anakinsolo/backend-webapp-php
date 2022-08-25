<?php
namespace DataProvider;

use PHPUnit\Framework\TestCase;
use Tuan\Fixably\Model\DataProvider\Invoice;

class InvoiceTest extends TestCase
{
    public function testGetData()
    {
        $invoiceDataProvider = new Invoice();
        $data = $invoiceDataProvider->getData();
        $this->assertIsArray($data);

        foreach ($data as $key => $report) {
            $this->assertArrayHasKey('week', $report);
            $this->assertArrayHasKey('total_invoices', $report);
            $this->assertArrayHasKey('total_invoiced_amount', $report);
            if ($key > 0) {
                $this->assertArrayHasKey('total_invoices_changed', $report);
                $this->assertArrayHasKey('total_invoiced_amount_changed', $report);
            }
        }
    }
}