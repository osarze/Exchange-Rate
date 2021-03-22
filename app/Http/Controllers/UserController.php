<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function setBaseCurrency(Request $request){
        $validator = Validator::make($request->input(), [
            'base_currency_code' => 'required|size:3'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->messages(), 422);
        }

        auth()->user()->base_currency_code = $request->base_currency_code;
        auth()->user()->save();

        return [
            'message' => 'Base currency updated successfully',
        ];
    }
}
