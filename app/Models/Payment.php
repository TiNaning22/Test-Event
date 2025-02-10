<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'participant_id',
        'event_id',
        'order_id',
        'amount',
        'status',
        'snap_token',
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array'
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
