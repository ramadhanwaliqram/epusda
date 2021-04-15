<?php

namespace App\Models\Superadmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class KategoriBerita extends Model
{
    use SoftDeletes;

    protected $table = 'kategori_beritas';
	protected $fillable = [
        'name'
    ];
    protected $guarded = [];
}
