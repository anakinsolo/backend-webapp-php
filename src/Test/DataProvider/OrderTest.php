<?php
namespace DataProvider;
use PHPUnit\Framework\TestCase;
use Tuan\Fixably\Model\DataProvider\Order;

class OrderTest extends TestCase
{
    public function testGetData()
    {
        $orderDataProvider = new Order();
        $this->assertIsArray($orderDataProvider->getData());
    }

    public function testCreateNewOrder()
    {
        $orderDataProvider = new Order();
        $order = $orderDataProvider->createNewOrder([], true);
        $this->assertIsArray($order);
        $this->assertArrayHasKey('id', $order);
        $this->assertArrayHasKey('error', $orderDataProvider->createNewOrder([]));
    }

    public function testCreateNewOrderNote()
    {
        $orderDataProvider = new Order();
        $order = $orderDataProvider->createNewOrder([], true);
        $note = $orderDataProvider->createNewOrderNote($order['id'], true);
        $this->assertIsArray($note);
        $this->assertArrayHasKey('id', $note);
    }
}