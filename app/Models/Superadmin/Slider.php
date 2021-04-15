<?php

namespace App\Models\Superadmin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Superadmin\{KabupatenKota, Sekolah};

class Slider extends Model
{

	protected $guarded = [];

    public function kabupatenKota()
    {
    	return $this->belongsTo(KabupatenKota::class);
    }

    public function sekolah()
    {
    	return $this->belongsToMany(Sekolah::class);
    }
}
