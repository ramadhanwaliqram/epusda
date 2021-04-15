<?php

namespace App\Models\Admin;

use App\Models\{MataPelajaran, Siswa};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarNilai extends Model
{
    use SoftDeletes;

    protected $table = 'daftar_nilai';
    protected $fillable = [
    	'kelas_id', 'siswa_id', 'mata_pelajaran_id', 'semester', 'tahun_ajaran', 'kategori_nilai', 'nilai', 'urutan_nilai'
    ];
    protected $guarded = [];
    
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }
    
    public function mataPelajaran() {
        return $this->belongsTo(MataPelajaran::class);
    }
}
