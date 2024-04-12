<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'video_path','description'];


    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
