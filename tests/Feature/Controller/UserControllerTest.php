<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use WithFaker;

    public function test_set_user_base_currency()
    {
        $user = User::factory(10)->create();
        $currencies = ["AUD", "CAD", "CHF", "CNY", "GBP", "JPY", "USD",];

        $selectedCurrency = $this->faker->randomElement($currencies);

        $response = $this->patchJson('/api/user/base_currency', ['currency' =>  $selectedCurrency])
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Base currency updated successfully'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'currency' => $selectedCurrency
        ]);


    }
}
