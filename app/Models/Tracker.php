<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Process;
use App\Models\Comment;
use Carbon\Carbon;

class Tracker extends Model
{
    use HasFactory;

    public function processes()
    {
        return $this->hasMany(Process::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($tracker){
            $tracker->processes->each(function($process){
               $process->delete();
            });

            $tracker->comments->each(function($comment){
               $comment->delete();
            });
        });
    }


}
