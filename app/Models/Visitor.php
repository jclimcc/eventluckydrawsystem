<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Prize;
use App\Models\Winner;
use App\Models\Event;
class Visitor extends Model
{
    use HasFactory;

    public function prizes()
    {
        return $this->hasManyThrough(Prize::class, Winner::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
