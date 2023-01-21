<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tracker;

class Process extends Model
{
    use HasFactory;

    public function tracker()
    {
        return $this->belongsTo(Tracker::class);
    }
}
