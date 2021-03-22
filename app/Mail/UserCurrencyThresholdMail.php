<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserCurrencyThreshold;

class UserCurrencyThresholdMail extends Mailable
{
    use Queueable, SerializesModels;

    public $currencyThreshold;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserCurrencyThreshold $userCurrencyThreshold)
    {
        $this->currencyThreshold = $userCurrencyThreshold;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('users.currency_threshold')
        ->subject('Exchange Rate Lower Than Currency Threshold');
    }
}
