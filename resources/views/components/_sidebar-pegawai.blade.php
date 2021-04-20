<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigation-label">Navigation</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->is('pegawai') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>

                @if ($employee->access->calendar)
                <li class="@if (request()->is('pegawai/kalender/kalender') || request()->is('pegawai/kalender/kegiatan-desa') || request()->is('pegawai/kalender/kategori-kegiatan')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <span class="pcoded-mtext">Kalender</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('pegawai/kalender/kalender') ? 'active' : '' }}">
                            <a href="{{ route('pegawai.kalender.kalender') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kalender</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('pegawai/kalender/kegiatan-desa') ? 'active' : '' }}">
                            <a href="{{ route('pegawai.kalender.kegiatan-desa') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kegiatan Desa</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('pegawai/kalender/kategori-kegiatan') ? 'active' : '' }}">
                            <a href="{{ route('pegawai.kalender.kategori-kegiatan') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kategori Kegiatan</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if ($employee->access->village_profile)
                <li class="{{ request()->is('pegawai/profil-desa') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.profil-desa.profil-desa') }}" class="waves-effect waves-dark">
                       <span class="pcoded-micon">
                           <i class="fa fa-id-badge"></i>
                       </span>
                       <span class="pcoded-mtext">Profil Desa</span>
                   </a>
                </li>
                @endif

                @if ($employee->access->village_tour)
                <li class="{{ request()->is('pegawai/wisata-desa') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.wisata-desa.wisata-desa') }}" class="waves-effect waves-dark">
                       <span class="pcoded-micon">
                           <i class="fa fa-map-marker-alt"></i>
                       </span>
                       <span class="pcoded-mtext">Wisata Desa</span>
                   </a>
                </li>
                @endif

                {{-- @if ($employee->access->village_structure)
                    <li class="@if (request()->is('pegawai/struktur/struktur') || request()->is('pegawai/struktur/pegawai') || request()->is('pegawai/struktur/jabatan')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                        <a href="javascript:void(0);" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fa fa-project-diagram"></i></span>
                            <span class="pcoded-mtext">Struktur Desa</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->is('pegawai/struktur/struktur') ? 'active' : '' }}">
                                <a href="{{ route('pegawai.struktur.struktur') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Struktur</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('pegawai/struktur/pegawai') ? 'active' : '' }}">
                                <a href="{{ route('pegawai.struktur.pegawai') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Pegawai</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('pegawai/struktur/jabatan') ? 'active' : '' }}">
                                <a href="{{ route('pegawai.struktur.jabatan') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Jabatan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif --}}

                {{-- <li class="@if (request()->is('admin/data-penduduk/keluarga') || request()->is('admin/data-penduduk/penduduk')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                        <span class="pcoded-mtext">Data Penduduk</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('admin/data-penduduk/keluarga') ? 'active' : '' }}">
                            <a href="{{ route('admin.data-penduduk.keluarga') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Keluarga</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/data-penduduk/penduduk') ? 'active' : '' }}">
                            <a href="{{ route('admin.data-penduduk.penduduk') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Penduduk</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="@if (request()->is('admin/administrasi/permohonan-pembuatan-ktp') || request()->is('admin/administrasi/surat-keterangan-lahir') || request()->is('admin/administrasi/perubahan-kk') || request()->is('admin/administrasi/surat-kematian') || request()->is('admin/administrasi/izin-usaha') || request()->is('admin/administrasi/keterangan-tidak-mampu') || request()->is('admin/administrasi/permohonan-skck') || request()->is('admin/administrasi/keterangan-pindah') || request()->is('admin/administrasi/keterangan-domisili') || request()->is('admin/administrasi/keterangan-ahli-waris') || request()->is('admin/administrasi/keterangan-tanah')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-archive"></i></span>
                        <span class="pcoded-mtext">Administrasi</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('admin/administrasi/permohonan-pembuatan-ktp') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.permohonan_pembuatan_ktp') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Permohonan KTP
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/surat-keterangan-lahir') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.surat_keterangan_lahir') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Surat Lahir
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/perubahan-kk') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.perubahan-kk') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Perubahan KK
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/surat-kematian') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.surat-kematian') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Surat Kematian
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/izin-usaha') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.izin_usaha') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Izin Usaha
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/keterangan-tidak-mampu') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.keterangan_tidak_mampu') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Ket. Tidak Mampu
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/permohonan-skck') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.permohonan-skck') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Permohonan SKCK
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/keterangan-pindah') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.keterangan-pindah') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Keterangan Pindah
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/keterangan-domisili') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.keterangan-domisili') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Keterangan Domisili
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/keterangan-ahli-waris') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.keterangan-ahli-waris') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Keterangan Ahli Waris
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/administrasi/keterangan-tanah') ? 'active' : '' }}">
                            <a href="{{ route('admin.administrasi.keterangan-tanah') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">
                                    Keterangan Tanah
                                    <label class="notification-label-danger ml-2" style="height: 5px; background-color: #FF5370; border-radius: 50%; padding: 3px;"></label>
                                    <label class="notification-label-warning" style="height: 5px; background-color: #FFB64D; border-radius: 50%; padding: 3px;"></label>
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if (request()->is('admin/potensi/potensi') || request()->is('admin/potensi/jenis-usaha') || request()->is('admin/potensi/kategori-usaha')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="icon-chart"></i></span>
                        <span class="pcoded-mtext">Potensi Desa</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('admin/potensi/potensi') ? 'active' : '' }}">
                            <a href="{{ route('admin.potensi.potensi') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Potensi Desa</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/potensi/jenis-usaha') ? 'active' : '' }}">
                            <a href="{{ route('admin.potensi.jenis-usaha') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Jenis Usaha</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/potensi/kategori-usaha') ? 'active' : '' }}">
                            <a href="{{ route('admin.potensi.kategori-usaha') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kategori Usaha</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if (request()->is('admin/berita/berita') || request()->is('admin/berita/kategori-berita')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="#" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-newspaper"></i>
                        </span>
                        <span class="pcoded-mtext">Berita</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('admin/berita/berita') ? 'active' : '' }}">
                            <a href="{{ route('admin.berita.berita') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Berita</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/berita/kategori-berita') ? 'active' : '' }}">
                            <a href="{{ route('admin.berita.kategori-berita') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kategori</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->is('admin/slider/slider') ? 'active' : '' }}">
                    <a href="{{ route('admin.slider.slider') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-gitlab"></i>
                        </span>
                        <span class="pcoded-mtext">Slider</span>
                    </a>
                </li>
                <li class="@if (request()->is('admin/peristiwa/kelahiran') || request()->is('admin/peristiwa/kematian') || request()->is('admin/peristiwa/pindah')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="icon-chart"></i></span>
                        <span class="pcoded-mtext">Peristiwa</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('admin/peristiwa/kelahiran') ? 'active' : '' }}">
                            <a href="{{ route('admin.peristiwa.kelahiran') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kelahiran</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/peristiwa/kematian') ? 'active' : '' }}">
                            <a href="{{ route('admin.peristiwa.kematian') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Kematian</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/peristiwa/pindah') ? 'active' : '' }}">
                            <a href="{{ route('admin.peristiwa.pindah') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Perpindahan</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->is('admin/wisata-desa') ? 'active' : '' }}">
                     <a href="{{ route('admin.wisata-desa.wisata-desa') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-map-marker-alt"></i>
                        </span>
                        <span class="pcoded-mtext">Wisata Desa</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/pengumuman') ? 'active' : '' }}">
                     <a href="{{ route('admin.pengumuman.pengumuman') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-bell"></i>
                        </span>
                        <span class="pcoded-mtext">Pengumuman</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/kampanye') ? 'active' : '' }}">
                     <a href="{{ route('admin.kampanye.kampanye') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-bullhorn"></i>
                        </span>
                        <span class="pcoded-mtext">Kampanye</span>
                    </a>
                </li>
                <li class="@if (request()->is('admin/referensi/pengaturan-hak-akses')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="javascript:void(0);" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fa fa-list-alt"></i></span>
                        <span class="pcoded-mtext">Referensi</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('admin/referensi/pengaturan-hak-akses') ? 'active' : '' }}">
                            <a href="{{ route('admin.referensi.pengaturan-hak-akses') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Pengaturan Hak Akses</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->is('admin/perpustakaan') ? 'active' : '' }}">
                    <a href="{{ route('admin.perpustakaan.perpustakaan') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-book-open"></i>
                        </span>
                        <span class="pcoded-mtext">Perpustakaan</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/pengaduan') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengaduan.pengaduan') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-comment-alt"></i>
                        </span>
                        <span class="pcoded-mtext">Pengaduan</span>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
