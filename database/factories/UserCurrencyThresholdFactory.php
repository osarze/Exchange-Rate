<?php

namespace Database\Factories;

use App\Models\UserCurrencyThreshold;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserCurrencyThresholdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserCurrencyThreshold::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'currency' => $this->faker->randomElement(["AUD", "CAD", "CHF", "CNY", "GBP", "JPY", "USD",]),
            'threshold' => mt_rand(1, 1000)
        ];
    }
}
