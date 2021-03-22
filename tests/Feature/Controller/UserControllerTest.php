<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private $user;
    private $selectedCurrency;

    public function setUp(): void{
        parent::setUp();

        $this->user = User::factory()->create();

        $currencies = ["AUD", "CAD", "CHF", "CNY", "GBP", "JPY", "USD",];

        $this->selectedCurrency = $this->faker->randomElement($currencies);
    }

    public function test_set_user_base_currency_route_validate_input(){
        $response = $this->actingAs($this->user)
        ->patchJson('/api/user/base_currency')
        ->assertStatus(422);

        $response = $this->actingAs($this->user)
        ->patchJson('/api/user/base_currency', ['base_currency_code' => 'podk'])
        ->assertStatus(422);

        $response = $this->actingAs($this->user)
        ->patchJson('/api/user/base_currency', ['base_currency_code' => $this->selectedCurrency])
        ->assertStatus(200);
    }

    public function test_set_user_base_currency()
    {
        $response = $this->actingAs($this->user)
        ->patchJson('/api/user/base_currency', ['base_currency_code' =>  $this->selectedCurrency])
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Base currency updated successfully'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'base_currency_code' => $this->selectedCurrency
        ]);
    }

    public function test_set_curency_rate_below_threshold_is_validated(){
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->actingAs($this->user)
        ->postJson('/api/user/currency_treshold', [
            'curency' =>  '',
            'treshold' =>''
        ]);
    }

    public function test_set_curency_rate_below_threshold(){
        $thresholdValue = mt_rand(1, 1000);
        $response = $this->actingAs($this->user)
        ->postJson('/api/user/currency_treshold', [
            'currency' =>  $this->selectedCurrency,
            'threshold' => $thresholdValue
        ])
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Threshold set successfully'
        ]);

        $this->assertDatabaseHas('user_currency_thresholds', [
            'user_id' => $this->user->id,
            'currency' => $this->selectedCurrency,
            'threshold' => $thresholdValue,
        ]);
    }
}
