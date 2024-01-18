<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Prize;
use App\Models\Winner;
class Visitor extends Model
{
    use HasFactory;

    public function prizes()
    {
        return $this->hasManyThrough(Prize::class, Winner::class);
    }
}
