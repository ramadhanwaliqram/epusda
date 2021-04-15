<?php

namespace App\Models\Superadmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Berita extends Model
{
    use SoftDeletes;

    protected $table = 'beritas';
	protected $fillable = [
        'name', 'kategori' , 'tanggal_rilis', 'isi', 'thumbnail'
    ];
    protected $guarded = [];
    protected $casts = ['created_at'=>'datetime:d-m-Y'];
}
