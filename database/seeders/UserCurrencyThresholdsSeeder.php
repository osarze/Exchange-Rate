<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserCurrencyThreshold;

class UserCurrencyThresholdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCurrencyThreshold::factory(20)->create();

        $this->command->info('Users currency threshold seeded successfully');
    }
}
