<?php
namespace Tuan\Fixably\Test;
use PHPUnit\Framework\TestCase;
use Tuan\Fixably\Model\OrderDataProvider;

class OrderDataProviderTest extends TestCase
{
    public function testGetData()
    {
        $orderDataProvider = new OrderDataProvider();
        $this->assertIsArray($orderDataProvider->getData());
    }

    public function testCreateNewOrder()
    {
        $orderDataProvider = new OrderDataProvider();
        $order = $orderDataProvider->createNewOrder([], true);
        $this->assertIsArray($order);
        $this->assertArrayHasKey('id', $order);
        $this->assertArrayHasKey('error', $orderDataProvider->createNewOrder([]));
    }

    public function testCreateNewOrderNote()
    {
        $orderDataProvider = new OrderDataProvider();
        $order = $orderDataProvider->createNewOrder([], true);
        $note = $orderDataProvider->createNewOrderNote($order['id'], true);
        $this->assertIsArray($note);
        $this->assertArrayHasKey('id', $note);
    }
}