<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySell extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_sells',
        'id_users',
        'status',
    ];
}
