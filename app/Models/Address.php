<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_users',
        'phone',
        'id_provinces',
        'id_cities',
        'id_districts',
        'id_villages',
        'name',
        'address',
        'postal_code',
    ];
}
