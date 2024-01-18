<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prize;
use App\Models\Visitor;
class Winner extends Model
{
    use HasFactory;

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

}
