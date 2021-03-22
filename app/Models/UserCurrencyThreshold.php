<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCurrencyThreshold extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency',
        'threshold'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
