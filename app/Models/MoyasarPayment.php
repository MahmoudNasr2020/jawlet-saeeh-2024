<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoyasarPayment extends Model
{
    use HasFactory;

    public $fillable = ['status','test_publishable_key','test_secret_key','live_publishable_key','live_secret_key'];
}
