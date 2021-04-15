<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigation-label">Navigation</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->is('guru') ? 'active' : '' }}">
                    <a href="{{ route('guru.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="@if (request()->is('guru/pengumuman/pesan')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-bell"></i></span>
                        <span class="pcoded-mtext">Pengumuman</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/pengumuman/pesan') ? 'active' : '' }}">
                            <a href="{{ route('guru.pengumuman.pesan') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Pesan</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if(auth()->user()->pegawai->access->kalender)
                <li class="@if (request()->is('guru/kalender/kalender-akademik')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-calendar"></i></span>
                        <span class="pcoded-mtext">Kalender</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/kalender/kalender-akademik') ? 'active' : '' }}">
                            <a href="{{ route('guru.kalender.kalender-akademik') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kalender Akademik</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->sekolah)
                <li class="@if (request()->is('guru/sekolah/jam') || request()->is('guru/sekolah/jurusan') || request()->is('guru/sekolah/kelas')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-school"></i></span>
                        <span class="pcoded-mtext">Sekolah</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/sekolah/jurusan') ? 'active' : '' }}">
                            <a href="{{ route('guru.sekolah.jurusan') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Jurusan</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/sekolah/kelas') ? 'active' : '' }}">
                            <a href="{{ route('guru.sekolah.kelas') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kelas</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/sekolah/jam') ? 'active' : '' }}">
                            <a href="{{ route('guru.sekolah.jam') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Jam Pelajaran</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->pelajaran)
                <li class="@if (request()->is('guru/pelajaran/mata-pelajaran') || request()->is('guru/pelajaran/jadwal-pelajaran')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                        <span class="pcoded-mtext">Pelajaran</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/pelajaran/mata-pelajaran') ? 'active' : '' }}">
                            <a href="{{ route('guru.pelajaran.mata-pelajaran') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Mata Pelajaran</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/pelajaran/jadwal-pelajaran') ? 'active' : '' }}">
                            <a href="{{ route('guru.pelajaran.jadwal-pelajaran') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Jadwal Pelajaran</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->peserta_didik)
                <li class="@if (request()->is('guru/peserta-didik/siswa') || request()->is('guru/peserta-didik/alumni') || request()->is('guru/peserta-didik/pindah-kelas') || request()->is('guru/peserta-didik/tidak-naik-kelas') || request()->is('guru/peserta-didik/siswa-pindahan') || request()->is('guru/peserta-didik/pengaturan-siswa-per-kelas')) pcoded-hasmenu pcoded-trigger active @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-graduation-cap"></i></span>
                        <span class="pcoded-mtext">Peserta Didik</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/peserta-didik/siswa') ? 'active' : '' }}">
                            <a href="{{ route('guru.pesertadidik.siswa.index') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Siswa</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/peserta-didik/alumni') ? 'active' : '' }}">
                            <a href="{{ route('guru.pesertadidik.alumni') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Alumni</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/peserta-didik/pindah-kelas') ? 'active' : '' }}">
                            <a href="{{ route('guru.pesertadidik.pindah-kelas') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Pindah Kelas</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/peserta-didik/tidak-naik-kelas') ? 'active' : '' }}">
                            <a href="{{ route('guru.pesertadidik.tidak-naik-kelas') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Tidak Naik Kelas</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/peserta-didik/siswa-pindahan') ? 'active' : '' }}">
                            <a href="{{ route('guru.pesertadidik.siswa-pindahan') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Siswa Pindahan</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/peserta-didik/pengaturan-siswa-per-kelas') ? 'active' : '' }}">
                            <a href="{{ route('guru.pesertadidik.pengaturan-siswa-per-kelas') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Pengaturan Siswa Per Kelas</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->absensi)
                <li class="@if (request()->is('guru/absensi/guru') || request()->is('guru/absensi/rekap-siswa')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-clipboard-list"></i></span>
                        <span class="pcoded-mtext">Absensi</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/absensi/siswa') ? 'active' : '' }}">
                            <a href="{{ route('guru.absensi.siswa') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Siswa</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/absensi/rekap-siswa') ? 'active' : '' }}">
                            <a href="{{ route('guru.absensi.rekap-siswa') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Rekap Siswa</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->daftar_nilai)
                <li class="{{ request()->is('guru/daftar-nilai') ? 'active' : '' }}">
                     <a href="{{ route('guru.daftar-nilai') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-medal"></i>
                        </span>
                        <span class="pcoded-mtext">Daftar Nilai</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->pelanggaran)
                <li class="@if (request()->is('guru/pelanggaran/siswa') || request()->is('guru/pelanggaran/sanksi') || request()->is('guru/pelanggaran/kategori-pelanggaran') || request()->is('guru/pelanggaran/surat-peringatan')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-exclamation-triangle"></i></span>
                        <span class="pcoded-mtext">Pelanggaran</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/pelanggaran/siswa') ? 'active' : '' }}">
                            <a href="{{ route('guru.pelanggaran.siswa') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Siswa</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->referensi)
                <li class="@if (request()->is('guru/referensi/bagian-pegawai') || request()->is('guru/referensi/semester') || request()->is('guru/referensi/status-guru') || request()->is('guru/referensi/pengaturan-hak-akses') || request()->is('guru/referensi/jenjang-pegawai') || request()->is('guru/referensi/tingkatan-kelas')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-list-alt"></i></span>
                        <span class="pcoded-mtext">Referensi</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/referensi/bagian-pegawai') ? 'active' : '' }}">
                            <a href="{{ route('guru.referensi.bagian-pegawai') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Bagian Pegawai</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/referensi/semester') ? 'active' : '' }}">
                            <a href="{{ route('guru.referensi.semester') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Semester</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/referensi/status-guru') ? 'active' : '' }}">
                            <a href="{{ route('guru.referensi.status-guru') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Status Guru</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/referensi/jenjang-pegawai') ? 'active' : '' }}">
                            <a href="{{ route('guru.referensi.jenjang-pegawai') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Jenjang Pegawai</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/referensi/tingkatan-kelas') ? 'active' : '' }}">
                            <a href="{{ route('guru.referensi.tingkatan-kelas') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Tingkatan Kelas</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/referensi/pengaturan-hak-akses') ? 'active' : '' }}">
                            <a href="{{ route('guru.referensi.pengaturan-hak-akses') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Pengaturan Hak Akses</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->pegawai->access->perpustakaan)
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                        <span class="pcoded-mtext">Perpustakaan</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="">
                            <a href="#!" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">E-Book</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="@if (request()->is('guru/fungsionaris/pegawai') || request()->is('guru/fungsionaris/guru')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-user-tie"></i></span>
                        <span class="pcoded-mtext">Fungsionaris</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/fungsionaris/pegawai') ? 'active' : '' }}">
                            <a href="{{ route('guru.fungsionaris.pegawai') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Pegawai</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/fungsionaris/guru') ? 'active' : '' }}">
                            <a href="{{ route('guru.fungsionaris.guru') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Guru</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if(auth()->user()->pegawai->access->e_voting)
                <li class="@if (request()->is('guru/e-voting/calon') || request()->is('guru/e-voting/posisi') || request()->is('guru/e-voting/pemilihan') || request()->is('guru/e-voting/vote')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-vote-yea"></i></span>
                        <span class="pcoded-mtext">E-Voting</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('guru/e-voting/calon') ? 'active' : '' }}">
                            <a href="{{ route('guru.e-voting.calon') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Calon</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/e-voting/posisi') ? 'active' : '' }}">
                            <a href="{{ route('guru.e-voting.posisi') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Posisi</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('guru/e-voting/pemilihan') ? 'active' : '' }}">
                            <a href="{{ route('guru.e-voting.pemilihan') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Pemilihan</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
