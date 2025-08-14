<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\ContactFormMail;

class ContactFormControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * フォーム表示のテスト
     */
    public function test_form_display()
    {
        $response = $this->get(route('contact.form'));

        $response->assertStatus(200);
        $response->assertViewIs('contact.form');
    }

    /**
     * フォーム送信のテスト（dataProvider使用）
     *
     * @dataProvider validFormDataProvider
     */
    public function test_valid_form_submission($formData, $expectedStatus, $expectedView)
    {
        $response = $this->post(route('contact.confirm'), $formData);

        $response->assertStatus($expectedStatus);
        $response->assertViewIs($expectedView);

        if ($expectedStatus === 200) {
            $response->assertViewHas('validated');
            // セッションにデータが保存されているか確認
            $this->assertNotEmpty(session('form_data'));
        }
    }

    /**
     * バリデーションエラーのテスト（dataProvider使用）
     *
     * @dataProvider invalidFormDataProvider
     */
    public function test_form_validation_errors($formData, $expectedErrors)
    {
        $response = $this->post(route('contact.confirm'), $formData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($expectedErrors);
    }

    /**
     * フォーマットメソッドのテスト（dataProvider使用）
     *
     * @dataProvider telFormattingDataProvider
     */
    public function test_tel_formatting($tel1, $tel2, $tel3, $expected)
    {
        $controller = new \App\Http\Controllers\ContactFormController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('formatTel');
        $method->setAccessible(true);

        $result = $method->invokeArgs($controller, [$tel1, $tel2, $tel3]);
        $this->assertEquals($expected, $result);
    }

    /**
     * 郵便番号フォーマットのテスト（dataProvider使用）
     *
     * @dataProvider zipFormattingDataProvider
     */
    public function test_zip_formatting($zip1, $zip2, $expected)
    {
        $controller = new \App\Http\Controllers\ContactFormController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('formatZip');
        $method->setAccessible(true);

        $result = $method->invokeArgs($controller, [$zip1, $zip2]);
        $this->assertEquals($expected, $result);
    }

    /**
     * フォーム送信完了のテスト
     */
    public function test_form_complete()
    {
        Mail::fake();

        // セッションにフォームデータを設定
        $formData = [
            'name' => '山田太郎',
            'tel' => '090-1234-5678',
            'email1' => 'test@example.com',
            'zip' => '123-4567',
            'address' => '東京都渋谷区神宮前1-1-1',
            'sample' => 'sample1'
        ];

        session(['form_data' => $formData]);

        $response = $this->post(route('contact.complete'));

        $response->assertStatus(200);
        $response->assertViewIs('contact.complete');

        // メールが送信されたか確認
        Mail::assertSent(ContactFormMail::class);

        // セッションからデータが削除されているか確認
        $this->assertEmpty(session('form_data'));
    }

    /**
     * セッションデータなしでの完了画面アクセステスト
     */
    public function test_complete_without_session_data()
    {
        $response = $this->post(route('contact.complete'));

        $response->assertStatus(302);
        $response->assertRedirect(route('contact.form'));
    }

    // データプロバイダー

    /**
     * 正常なフォームデータのプロバイダー
     */
    public static function validFormDataProvider(): array
    {
        return [
            '全項目入力' => [
                [
                    'name' => '山田太郎',
                    'tel1' => '090',
                    'tel2' => '1234',
                    'tel3' => '5678',
                    'email1' => 'test@example.com',
                    'email2' => 'test@example.com',
                    'zip1' => '123',
                    'zip2' => '4567',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                200,
                'contact.confirm'
            ],
            '必須項目のみ入力' => [
                [
                    'name' => '佐藤花子',
                    'email1' => 'hanako@example.com',
                    'email2' => 'hanako@example.com',
                ],
                200,
                'contact.confirm'
            ],
            '英数字名前' => [
                [
                    'name' => 'John Smith',
                    'email1' => 'john@example.com',
                    'email2' => 'john@example.com',
                    'address' => 'Tokyo, Japan',
                    'sample' => 'sample3'
                ],
                200,
                'contact.confirm'
            ]
        ];
    }

    /**
     * 無効なフォームデータのプロバイダー
     */
    public static function invalidFormDataProvider(): array
    {
        return [
            '必須項目未入力' => [
                [
                    'name' => '',
                    'email1' => '',
                    'email2' => '',
                ],
                ['name', 'email1', 'email2']
            ],
            'メールアドレス不一致' => [
                [
                    'name' => '山田太郎',
                    'email1' => 'test1@example.com',
                    'email2' => 'test2@example.com',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                ['email2']
            ],
            '無効なメールアドレス形式' => [
                [
                    'name' => '山田太郎',
                    'email1' => 'invalid-email',
                    'email2' => 'invalid-email',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                ['email1', 'email2']
            ],
            '無効な郵便番号形式' => [
                [
                    'name' => '山田太郎',
                    'email1' => 'test@example.com',
                    'email2' => 'test@example.com',
                    'zip1' => '12',
                    'zip2' => '456',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                ['zip1', 'zip2']
            ],
            '電話番号部分入力' => [
                [
                    'name' => '山田太郎',
                    'tel1' => '090',
                    'tel2' => '',
                    'tel3' => '',
                    'email1' => 'test@example.com',
                    'email2' => 'test@example.com',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                ['tel']
            ],
            '郵便番号部分入力' => [
                [
                    'name' => '山田太郎',
                    'email1' => 'test@example.com',
                    'email2' => 'test@example.com',
                    'zip1' => '123',
                    'zip2' => '',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                ['zip']
            ],
            '名前が長すぎる' => [
                [
                    'name' => str_repeat('あ', 256),
                    'email1' => 'test@example.com',
                    'email2' => 'test@example.com',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                ['name']
            ],
            'メールアドレスが長すぎる' => [
                [
                    'name' => '山田太郎',
                    'email1' => str_repeat('a', 250) . '@example.com',
                    'email2' => str_repeat('a', 250) . '@example.com',
                    'address' => '東京都渋谷区神宮前1-1-1',
                    'sample' => 'sample1'
                ],
                ['email1', 'email2']
            ]
        ];
    }

    /**
     * 電話番号フォーマットのデータプロバイダー
     */
    public static function telFormattingDataProvider(): array
    {
        return [
            '全て空' => ['', '', '', ''],
            '正常な入力' => ['090', '1234', '5678', '090-1234-5678'],
            '固定電話' => ['03', '1234', '5678', '03-1234-5678'],
            '携帯電話（080）' => ['080', '9876', '5432', '080-9876-5432'],
            '携帯電話（070）' => ['070', '1111', '2222', '070-1111-2222'],
            'スペース含む' => [' 090 ', ' 1234 ', ' 5678 ', ' 090 - 1234 - 5678 '],
        ];
    }

    /**
     * 郵便番号フォーマットのデータプロバイダー
     */
    public static function zipFormattingDataProvider(): array
    {
        return [
            '全て空' => ['', '', ''],
            '正常な入力' => ['123', '4567', '123-4567'],
            '東京都' => ['100', '0001', '100-0001'],
            '大阪府' => ['530', '0001', '530-0001'],
            'スペース含む' => [' 123 ', ' 4567 ', ' 123 - 4567 '],
        ];
    }
}
