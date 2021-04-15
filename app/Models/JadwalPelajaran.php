<?php

namespace App\Models;

use App\Http\Controllers\Admin\Sekolah\JamPelajaranController;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    public function mataPelajaran() {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
    public function jamPelajaran() {
        return $this->belongsTo(JamPelajaran::class, 'jam_pelajaran');
    }
    public function kelas() {
        return $this->belongsTo(Admin\Kelas::class);
    }
}
