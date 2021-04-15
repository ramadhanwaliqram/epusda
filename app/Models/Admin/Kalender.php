<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kalender extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sekolah_id','title', 'start_date', 'end_date', 'start_clock', 'end_clock', 'prioritas',
    ];
    protected $table = "kalenders";
    protected $guarded = [];
}
