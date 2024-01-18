<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Prize;
class Event extends Model
{
    use HasFactory;

    public function prizes()
    {
        return $this->hasMany(Prize::class);
    }
}
