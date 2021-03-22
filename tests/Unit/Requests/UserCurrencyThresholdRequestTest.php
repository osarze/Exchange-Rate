<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\UserCurrencyThresholdRequest;
use App\Models\User;

class UserCurrencyThresholdRequestTest extends TestCase
{
    use RefreshDatabase;

    private $rules;
    private $testData;
    private $user;
    private $currencies;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->rules = (new UserCurrencyThresholdRequest())->rules();
        $this->currencies = ["AUD", "CAD", "CHF", "CNY", "GBP", "JPY", "USD",];
        $this->testData = [
            'user_id' => 345,
            'currency' => $this->currencies[mt_rand(0, 6)],
            'threshold' => mt_rand(1,28),
        ];
    }

    public function test_currency_is_required()
    {
        $this->testData['currency'] = '';
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertTrue($validator->fails());

        $this->testData['currency'] = $this->currencies[mt_rand(0, 6)];
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertFalse($validator->fails());
    }

    public function test_currency_length_must_be_3()
    {
        $this->testData['currency'] = 'NB';
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertTrue($validator->fails());

        $this->testData['currency'] = 'YYSSY';
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertTrue($validator->fails());

        $this->testData['currency'] = $this->currencies[mt_rand(0, 6)];
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertFalse($validator->fails());
    }

    public function test_threshhold_value_is_required()
    {
        $this->testData['threshold'] = '';
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertTrue($validator->fails());

        $this->testData['threshold'] = 34;
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertFalse($validator->fails());
    }

    public function test_threshhold_value_must_be_digits_or_whole_number()
    {
        $this->testData['threshold'] = 'ee4rfr';
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertTrue($validator->fails());

        $this->testData['threshold'] = '343.45.5';
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertTrue($validator->fails());

        $this->testData['threshold'] = 34;
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertFalse($validator->fails());

        $this->testData['threshold'] = 343.455;
        $validator = Validator::make($this->testData, $this->rules);
        $this->assertFalse($validator->fails());
    }
}
