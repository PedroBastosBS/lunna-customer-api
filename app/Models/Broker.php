<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    use HasFactory;

    protected $table = "brokers";
    
    protected $fillable = [
        'user_id',
        'creci',
        'description',
        'real_estate_id',
        'rating'
    ];
}
