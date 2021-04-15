<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'kode', 'name', 'user_id'
    ];
    protected $table = "jurusans";
    protected $guarded = [];
}
