<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\CustomerService;

class CustomerServiceTest extends TestCase
{
    private CustomerService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CustomerService();
    }

    public function test_get_prefectures_returns_all_japanese_prefectures()
    {
        $prefectures = $this->service->getPrefectures();

        $this->assertIsArray($prefectures);
        $this->assertCount(47, $prefectures);
        $this->assertContains('東京都', $prefectures);
        $this->assertContains('北海道', $prefectures);
        $this->assertContains('沖縄県', $prefectures);
    }

    /**
     * @dataProvider customerDataProvider
     */
    public function test_prepare_customer_data($inputData, $expectedKeys)
    {
        $result = $this->service->prepareCustomerData($inputData);

        $this->assertIsArray($result);
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result);
        }

        // Test that building defaults to empty string when not provided
        if (!isset($inputData['building'])) {
            $this->assertEquals('', $result['building']);
        }
    }

    /**
     * @dataProvider shippingDataProvider
     */
    public function test_prepare_shipping_data($inputData, $expectedKeys)
    {
        $result = $this->service->prepareShippingData($inputData);

        $this->assertIsArray($result);
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result);
        }

        // Test that all fields default to empty string when not provided
        foreach ($expectedKeys as $key) {
            if (!isset($inputData[$key])) {
                $this->assertEquals('', $result[$key]);
            }
        }
    }

    /**
     * @dataProvider customerToShippingProvider
     */
    public function test_copy_customer_to_shipping($customerData, $expectedMapping)
    {
        $result = $this->service->copyCustomerToShipping($customerData);

        $this->assertIsArray($result);
        foreach ($expectedMapping as $shippingKey => $customerKey) {
            $this->assertEquals($customerData[$customerKey], $result[$shippingKey]);
        }
    }

    /**
     * @dataProvider sessionRestoreProvider
     */
    public function test_restore_customer_from_session($sessionData, $expectedDefaults)
    {
        $result = $this->service->restoreCustomerFromSession($sessionData);

        $this->assertIsArray($result);
        foreach ($expectedDefaults as $key => $defaultValue) {
            if (isset($sessionData[$key])) {
                $this->assertEquals($sessionData[$key], $result[$key]);
            } else {
                $this->assertEquals($defaultValue, $result[$key]);
            }
        }
    }

    public function test_restore_shipping_from_session()
    {
        $sessionData = [
            'same_as_customer' => true,
            'shipping_name' => 'Test User',
            'shipping_email' => 'test@example.com'
        ];

        $result = $this->service->restoreShippingFromSession($sessionData);

        $this->assertIsArray($result);
        $this->assertTrue($result['same_as_customer']);
        $this->assertEquals('Test User', $result['shipping_name']);

        // Test defaults for missing keys
        $this->assertEquals('', $result['shipping_kana'] ?? '');
    }

    public static function customerDataProvider()
    {
        $requiredKeys = ['name', 'kana', 'email', 'tel', 'zip', 'prefecture', 'city', 'address', 'building'];

        return [
            'complete data' => [
                [
                    'name' => '田中太郎',
                    'kana' => 'タナカタロウ',
                    'email' => 'tanaka@example.com',
                    'tel' => '03-1234-5678',
                    'zip' => '100-0001',
                    'prefecture' => '東京都',
                    'city' => '千代田区',
                    'address' => '霞が関1-1-1',
                    'building' => 'テストビル101'
                ],
                $requiredKeys
            ],
            'without building' => [
                [
                    'name' => '田中太郎',
                    'kana' => 'タナカタロウ',
                    'email' => 'tanaka@example.com',
                    'tel' => '03-1234-5678',
                    'zip' => '100-0001',
                    'prefecture' => '東京都',
                    'city' => '千代田区',
                    'address' => '霞が関1-1-1'
                ],
                $requiredKeys
            ]
        ];
    }

    public static function shippingDataProvider()
    {
        $requiredKeys = [
            'shipping_name', 'shipping_kana', 'shipping_tel', 'shipping_zip',
            'shipping_prefecture', 'shipping_city', 'shipping_address', 'shipping_building'
        ];

        return [
            'complete data' => [
                [
                    'shipping_name' => '田中太郎',
                    'shipping_kana' => 'タナカタロウ',
                    'shipping_tel' => '03-1234-5678',
                    'shipping_zip' => '100-0001',
                    'shipping_prefecture' => '東京都',
                    'shipping_city' => '千代田区',
                    'shipping_address' => '霞が関1-1-1',
                    'shipping_building' => 'テストビル101'
                ],
                $requiredKeys
            ],
            'empty data' => [
                [],
                $requiredKeys
            ]
        ];
    }

    public static function customerToShippingProvider()
    {
        return [
            'standard mapping' => [
                [
                    'name' => '田中太郎',
                    'kana' => 'タナカタロウ',
                    'tel' => '03-1234-5678',
                    'zip' => '100-0001',
                    'prefecture' => '東京都',
                    'city' => '千代田区',
                    'address' => '霞が関1-1-1',
                    'building' => 'テストビル101'
                ],
                [
                    'shipping_name' => 'name',
                    'shipping_kana' => 'kana',
                    'shipping_tel' => 'tel',
                    'shipping_zip' => 'zip',
                    'shipping_prefecture' => 'prefecture',
                    'shipping_city' => 'city',
                    'shipping_address' => 'address',
                    'shipping_building' => 'building'
                ]
            ]
        ];
    }

    public static function sessionRestoreProvider()
    {
        $customerDefaults = [
            'name' => '',
            'kana' => '',
            'email' => '',
            'tel' => '',
            'zip' => '',
            'prefecture' => '',
            'city' => '',
            'address' => '',
            'building' => ''
        ];

        return [
            'with data' => [
                ['name' => '田中太郎', 'email' => 'tanaka@example.com'],
                $customerDefaults
            ],
            'empty session' => [
                [],
                $customerDefaults
            ]
        ];
    }
}
