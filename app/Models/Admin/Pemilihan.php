<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Calon;
use App\Models\Admin\Voting;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemilihan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'posisi', 'sekolah_id', 'start_date', 'end_date'
    ];
    protected $table = "pemilihan";
    protected $guarded = [];

    public function calons(){
    	return $this->belongsToMany(Calon::class);
    }

    public function votes(){
    	return $this->hasMany(Voting::class);
    }

}
