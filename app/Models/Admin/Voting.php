<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Pemilihan;

class Voting extends Model
{
    use SoftDeletes;
    protected $table = 'votings';
    protected $fillable = [
        'pemilihan_id', 'calon_id', 'id_user'
    ];
    protected $guarded = [];

    public function pemilihan(){
    	return $this->belongsTo(Pemilihan::class);
    }
}
