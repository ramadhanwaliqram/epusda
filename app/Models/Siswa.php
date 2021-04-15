<?php

namespace App\Models;

use App\Models\Admin\{Kelas, DaftarNilai};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts =[
        'tanggal_masuk' => 'datetime:d-m-Y',
        'tanggal_lahir' => 'datetime:d-m-Y'
    ];

    public function siswaOrangTua() {
        return $this->belongsTo(SiswaOrangTua::class, 'id', 'id_siswa');
    }

    public function siswaWali() {
        return $this->belongsTo(SiswaWali::class, 'id', 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function absensi() {
        return $this->hasOne(Absensi::class);
    }

    public function absensis() {
        return $this->hasMany(Absensi::class);
    }

    public function nilai()
    {
        return $this->hasMany(DaftarNilai::class);
    }
}
