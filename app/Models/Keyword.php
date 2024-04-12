<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'role'];

        // リレーションシップを設定する
        public function user()
        {
            return $this->belongsTo(User::class);
        }
}
