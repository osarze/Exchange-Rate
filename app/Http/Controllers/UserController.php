<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setBaseCurrency(){
        return [
            'message' => 'Base currency updated successfully',
        ];
    }
}
