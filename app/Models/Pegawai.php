<?php

namespace App\Models;

use App\User;
use App\Models\Admin\Access;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;

    // protected $fillable = [
    //     'user_id', 'name', 'nip', 'nik', 'gelar_depan', 'gelar_belakang',
    //     'tempat_lahir', 'tanggal_lahir', 'jk', 'agama', 'is_menikah', 'alamat_tinggal',
    //     'provinsi_id', 'kabupaten_kota_id', 'kecamatan_id', 'dusun', 'rt', 'rw', 'kode_pos', 'no_telepon_rumah',
    //     'no_telepon', 'tanggal_mulai', 'bagian_pegawai_id', 'tahun_ajaran', 'semester_id', 'foto'
    // ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function access()
    {
        return $this->hasOne(Access::class);
    }
}
