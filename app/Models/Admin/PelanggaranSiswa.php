<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PelanggaranSiswa extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'nama_siswa', 'siswa_id', 'tanggal_pelanggaran', 'pelanggaran', 'poin', 'sebab', 'sanksi', 'penanganan', 'keterangan'
    ];
    protected $table = "pelanggaran_siswas";
    protected $guarded = [];

   public function siswa(){
   		return $this->hasOne(Siswa::class);
   }
}
