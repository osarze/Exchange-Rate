<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Events\UserCurrencyThresholdExceededEvent;

class CheckUserCurrencyThresholdValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:currency_threshold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereNotNull('base_currency_code')
        ->has('currencyThreshold')
        ->get();

        foreach($users as $user){
            $url = config('fixer.base_uri') . 'latest?access_key=' . config('fixer.access_key');
            $url .= '&base=' . $user->base_currency_code;

            $response = Http::get($url);
            $response = json_decode($response->getBody(), true);

            $exchangeRates = collect($response['rates']);


            foreach($user->currencyThreshold as $threshold){
                $lowerThanThreshold = $exchangeRates->filter(function($rate, $index) use($threshold){
                    return $index == $threshold->currency && $threshold->threshold < $rate;
                });
                if($lowerThanThreshold->count() > 0){
                    event(new UserCurrencyThresholdExceededEvent($threshold));
                }
            }
        }

        return 0;
    }
}
