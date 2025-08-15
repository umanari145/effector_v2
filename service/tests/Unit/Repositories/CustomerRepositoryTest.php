<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\CustomerRepository;
use App\Models\Customer;
use App\Models\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CustomerRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CustomerRepository();
    }

    /**
     * @dataProvider customerDataProvider
     */
    public function test_create_customer($customerData)
    {
        $customer = $this->repository->createCustomer($customerData);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($customerData['name'], $customer->name);
        $this->assertEquals($customerData['email'], $customer->email);
        $this->assertEquals($customerData['building'] ?? '', $customer->building);

        $this->assertDatabaseHas('customers', [
            'name' => $customerData['name'],
            'kana' => $customerData['kana'],
            'tel' => $customerData['tel'],
            'email' => $customerData['email'],
            'zip' => $customerData['zip'],
            'prefecture' => $customerData['prefecture'],
            'city' => $customerData['city'],
            'address' => $customerData['address'],
            'building' => $customerData['building'] ?? ''
        ]);
    }

    /**
     * @dataProvider shippingDataProvider
     */
    public function test_create_shipping($shippingData)
    {
        $shipping = $this->repository->createShipping($shippingData);

        $this->assertInstanceOf(Shipping::class, $shipping);
        $this->assertEquals($shippingData['shipping_name'], $shipping->shipping_name);
        $this->assertEquals($shippingData['shipping_tel'], $shipping->shipping_tel);
        $this->assertEquals($shippingData['shipping_building'] ?? '', $shipping->shipping_building);

        $this->assertDatabaseHas('shippings', [
            'shipping_name' => $shippingData['shipping_name'],
            'shipping_kana' => $shippingData['shipping_kana'],
            'shipping_tel' => $shippingData['shipping_tel'],
            'shipping_zip' => $shippingData['shipping_zip'],
            'shipping_prefecture' => $shippingData['shipping_prefecture'],
            'shipping_city' => $shippingData['shipping_city'],
            'shipping_address' => $shippingData['shipping_address'],
            'shipping_building' => $shippingData['shipping_building'] ?? ''
        ]);
    }

    public function test_create_customer_with_minimal_data()
    {
        $customerData = [
            'name' => '田中太郎',
            'kana' => 'タナカタロウ',
            'tel' => '03-1234-5678',
            'email' => 'tanaka@example.com',
            'zip' => '100-0001',
            'prefecture' => '東京都',
            'city' => '千代田区',
            'address' => '霞が関1-1-1'
        ];

        $customer = $this->repository->createCustomer($customerData);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('', $customer->building); // Should default to empty string
    }

    public function test_create_shipping_with_minimal_data()
    {
        $shippingData = [
            'shipping_name' => '田中太郎',
            'shipping_kana' => 'タナカタロウ',
            'shipping_tel' => '03-1234-5678',
            'shipping_zip' => '100-0001',
            'shipping_prefecture' => '東京都',
            'shipping_city' => '千代田区',
            'shipping_address' => '霞が関1-1-1'
        ];

        $shipping = $this->repository->createShipping($shippingData);

        $this->assertInstanceOf(Shipping::class, $shipping);
        $this->assertEquals('', $shipping->shipping_building); // Should default to empty string
    }

    public static function customerDataProvider()
    {
        return [
            'complete customer data' => [[
                'name' => '田中太郎',
                'kana' => 'タナカタロウ',
                'tel' => '03-1234-5678',
                'email' => 'tanaka@example.com',
                'zip' => '100-0001',
                'prefecture' => '東京都',
                'city' => '千代田区',
                'address' => '霞が関1-1-1',
                'building' => 'テストビル101'
            ]],
            'customer without building' => [[
                'name' => '佐藤花子',
                'kana' => 'サトウハナコ',
                'tel' => '06-9876-5432',
                'email' => 'sato@example.com',
                'zip' => '530-0001',
                'prefecture' => '大阪府',
                'city' => '大阪市北区',
                'address' => '梅田1-1-1'
            ]],
            'customer with special characters' => [[
                'name' => '高橋一郎',
                'kana' => 'タカハシイチロウ',
                'tel' => '03-0000-0000',
                'email' => 'takahashi+test@example.com',
                'zip' => '150-0001',
                'prefecture' => '東京都',
                'city' => '渋谷区',
                'address' => '神宮前1-1-1',
                'building' => 'マンション・テスト101号室'
            ]]
        ];
    }

    public static function shippingDataProvider()
    {
        return [
            'complete shipping data' => [[
                'shipping_name' => '田中太郎',
                'shipping_kana' => 'タナカタロウ',
                'shipping_tel' => '03-1234-5678',
                'shipping_zip' => '100-0001',
                'shipping_prefecture' => '東京都',
                'shipping_city' => '千代田区',
                'shipping_address' => '霞が関1-1-1',
                'shipping_building' => 'テストビル101'
            ]],
            'shipping without building' => [[
                'shipping_name' => '佐藤花子',
                'shipping_kana' => 'サトウハナコ',
                'shipping_tel' => '06-9876-5432',
                'shipping_zip' => '530-0001',
                'shipping_prefecture' => '大阪府',
                'shipping_city' => '大阪市北区',
                'shipping_address' => '梅田1-1-1'
            ]]
        ];
    }
}
