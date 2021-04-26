<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'user_id', 'library_id', 'ebook_expired_at', 'audio_expired_at', 'video_expired_at', 'total_of_borrow'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
