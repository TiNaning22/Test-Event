<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'ticket_quantity',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
