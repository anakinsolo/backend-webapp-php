<?php
namespace DataProvider;

use PHPUnit\Framework\TestCase;
use Tuan\Fixably\Model\DataProvider\Iphone;

class IphoneTest extends TestCase
{
    public function testGetData()
    {
        $iphoneDataProvider = new Iphone();
        $orderData = $iphoneDataProvider->getData();
        $this->assertIsArray($orderData);

        foreach ($orderData as $data) {
            $this->assertArrayHasKey('deviceType', $data, 'has key: deviceType');
            $this->assertStringContainsString('Phone', $data['deviceType'], 'has dataType: Phone');

            $this->assertArrayHasKey('deviceManufacturer', $data, 'has key: deviceManufacturer');
            $this->assertStringContainsString('Apple', $data['deviceManufacturer'], 'has deviceManufacturer: Apple');

            $this->assertArrayHasKey('deviceBrand', $data, 'has key deviceBrand');
            $this->assertStringContainsString('iPhone', $data['deviceBrand'], 'has deviceBrand: iPhone*');

            $this->assertArrayHasKey('technician', $data, 'has key technician');
            $this->assertNotNull($data['technician'], 'technician is NOT NULL');

            $this->assertArrayHasKey('status', $data, 'has key status');
            $this->assertEquals(3, (int)$data['status'], 'has status: 3');
        }

    }
}