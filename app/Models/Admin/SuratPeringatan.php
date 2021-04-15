<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratPeringatan extends Model
{
    use SoftDeletes;

    protected $table = 'surat_peringatans';
	protected $fillable = [
        'name', 'poin', 'sekolah_id'
    ];
    protected $guarded = [];
}
