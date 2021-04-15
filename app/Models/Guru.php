<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Pegawai;
use App\Models\{JadwalPelajaran, MataPelajaran};
class Guru extends Model
{
    protected $fillable = ['nama', 'status_guru', 'is_aktif', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function jadwalPelajaran() {
    	return $this->hasManyThrough(JadwalPelajaran::class, MataPelajaran::class);
    }

    public function jamPelajaran() {
        return $this->hasManyThrough(jamPelajaran::class);
    }
}
