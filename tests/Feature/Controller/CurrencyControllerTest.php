<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class CurrencyControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_currency_for_user_base_currency()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
        ->getJson('api/currencies/exchange-rates')
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'base' => $user->base_currency_code,
            'rates' => [

            ]
        ]);
    }
}
