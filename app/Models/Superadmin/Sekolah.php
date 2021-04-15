<?php

namespace App\Models\Superadmin;

use App\Models\Superadmin\Slider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function access()
    {
    	return $this->hasMany(App\Models\Admin\Access::class);
    }

    public function sliders()
    {
    	return $this->belongsToMany(Slider::class);
    }
}
