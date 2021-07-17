<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_users',
        'id_addresses',
        'id_addresses',
        'id_types',
        'qty',
    ];
}
