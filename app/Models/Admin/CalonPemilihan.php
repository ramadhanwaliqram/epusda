<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Models\Admin\Pemilihan;
use App\Models\Admin\Calon;

class CalonPemilihan extends Model
{
    // use SoftDeletes;

    protected $table = 'calon_pemilihan';
	protected $fillable = [
        'name', 'user_id'
    ];
    protected $guarded = [];

    // public function user()
    // {
    // 	return $this->belongsTo(User::class);
    // }

    public function pemilihans(){
        return $this->belongsToMany(Pemilihan::class);
    }

    public function calon(){
        return $this->hasOne(Calon::class, 'id', 'calon_id')->orderBy('name');
    }

}