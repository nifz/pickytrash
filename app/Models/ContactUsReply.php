<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsReply extends Model
{
    use HasFactory;

    protected $table = "contact_us_reply";
    protected $fillable = [
        'id_contact_us',
        'name',
        'email',
        'subject',
        'message',
        'is_reply',
    ];
}
