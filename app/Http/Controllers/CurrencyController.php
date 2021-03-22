<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function getCurrencyExchangeRate(){
        $url = config('fixer.base_uri') . 'latest?access_key=' . config('fixer.access_key');
        $url .= '&base=' . auth()->user()->base_currency_code;

        $response = Http::get($url);
        $response = json_decode($response->getBody());

        $statusCode = $response->success ? 200 : 400;

        return response()->json($response, $statusCode);
    }
}
