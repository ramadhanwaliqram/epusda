@extends('layouts.admin')

{{-- config 1 --}}
@section('title', 'Referensi | Pengaturan Hak Akses')
@section('title-2', 'Pengaturan Hak Akses')
@section('title-3', 'Pengaturan Hak Akses')

@section('describ')
    Ini adalah halaman pengaturan hak akses untuk admin
@endsection

@section('icon-l', 'fa fa-list-alt')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('admin.referensi.pengaturan-hak-akses') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <div class="toolbar">
                            <h6>Keterangan :</h6>
                            <ol>
                                <div class="row">
                                    <div class="col-md-4">
                                        <li>KA : Kalender</li>
                                        <li>SE : Sekolah</li>
                                        <li>PEL : Pelajaran</li>
                                        <li>PD : Peserta Didik</li>
                                        <li>AB : Absensi</li>
                                        <li>DN : Daftar Nilai</li>
                                    </div>
                                    <div class="col-md-4">
                                        <li>PLG : Pelanggaran</li>
                                        <li>TE : Template</li>
                                        <li>LU : Log User</li>
                                        <li>R : Referensi</li>
                                        <li>BT : Buku Tamu</li>
                                        <li>KO : Konsultasi</li>
                                    </div>
                                    <div class="col-md-4">
                                        <li>PER : Perpustakaan</li>
                                        <li>KE : Keuangan</li>
                                        <li>S&P : Sarana & Prasarana</li>
                                        <li>PMB : Penerimaan Murid Baru</li>
                                        <li>USBK : Ujian Sekolah Berbasis Komputer</li>
                                        <li>EVO : E-voting</li>
                                    </div>
                                </div>
                            </ol>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                                <thead>
                                    <tr class="text-left">
                                    <th>Nama</th>
                                    <th title="Kalender">KA</th>
                                    <th title="Sekolah">SE</th>
                                    <th title="Pelajaran">PEL</th>
                                    <th title="Peserta Didik">PD</th>
                                    <th title="Absensi">AB</th>
                                    <th title="Daftar Nilai">DN</th>
                                    <th title="Pelanggaran">PLG</th>
                                    <th title="Template">TE</th>
                                    <th title="Log User">LU</th>
                                    <th title="Referensi">R</th>
                                    <th title="Buku Tamu">BT</th>
                                    <th title="Perpustakaan">PER</th>
                                    <th title="Keuangan">KE</th>
                                    <th title="Sarana & Prasarana">S&P</th>
                                    <th title="Penerimaan Murid Baru">PMB</th>
                                    <th title="Ujian Sekolah Berbasis Komputer">USBK</th>
                                    <th title="E-voting">EVO</th>
                                    <th title="Konsultasi">KO</th>
                                </tr>
                                </thead>
                                <tbody  class="text-left">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($pegawais as $pegawai)
                                    <tr>
                                        <td>{{ $pegawai->name }}</br> ({{ $pegawai->bagian }})</td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" {{ $pegawai->access->kalender==1?"checked":"" }} id="kalender{{ $i }}" onclick="check('{{ $pegawai->id }}', '#kalender{{ $i }}', 'kalender');">
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->sekolah==1?"checked":"" }} id="sekolah{{ $i }}" onclick="check('{{ $pegawai->id }}', '#sekolah{{ $i }}', 'sekolah');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->pelajaran==1?"checked":"" }} id="pelajaran{{ $i }}" onclick="check('{{ $pegawai->id }}', '#pelajaran{{ $i }}', 'pelajaran');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->peserta_didik==1?"checked":"" }} id="peserta_didik{{ $i }}" onclick="check('{{ $pegawai->id }}', '#peserta_didik{{ $i }}', 'peserta_didik');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->absensi==1?"checked":"" }} id="absensi{{ $i }}" onclick="check('{{ $pegawai->id }}', '#absensi{{ $i }}', 'absensi');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->daftar_nilai==1?"checked":"" }} id="daftar_nilai{{ $i }}" onclick="check('{{ $pegawai->id }}', '#daftar_nilai{{ $i }}', 'daftar_nilai');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->pelanggaran==1?"checked":"" }} id="pelanggaran{{ $i }}" onclick="check('{{ $pegawai->id }}', '#pelanggaran{{ $i }}', 'pelanggaran');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->template==1?"checked":"" }} id="template{{ $i }}" onclick="check('{{ $pegawai->id }}', '#template{{ $i }}', 'template');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->log_user==1?"checked":"" }} id="log_user{{ $i }}" onclick="check('{{ $pegawai->id }}', '#log_user{{ $i }}', 'log_user');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->referensi==1?"checked":"" }} id="referensi{{ $i }}" onclick="check('{{ $pegawai->id }}', '#referensi{{ $i }}', 'referensi');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->buku_tamu==1?"checked":"" }} id="buku_tamu{{ $i }}" onclick="check('{{ $pegawai->id }}', '#buku_tamu{{ $i }}', 'buku_tamu');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->perpustakaan==1?"checked":"" }} id="perpustakaan{{ $i }}" onclick="check('{{ $pegawai->id }}', '#perpustakaan{{ $i }}', 'perpustakaan');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->keuangan==1?"checked":"" }} id="keuangan{{ $i }}" onclick="check('{{ $pegawai->id }}', '#keuangan{{ $i }}', 'keuangan');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->sarana_prasarana==1?"checked":"" }} id="sarana_prasarana{{ $i }}" onclick="check('{{ $pegawai->id }}', '#sarana_prasarana{{ $i }}', 'sarana_prasarana');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->penerimaan_murid_baru==1?"checked":"" }} id="pmb{{ $i }}" onclick="check('{{ $pegawai->id }}', '#pmb{{ $i }}', 'penerimaan_murid_baru');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->ujian_sekolah_berbasis_komputer==1?"checked":"" }} id="usbk{{ $i }}" onclick="check('{{ $pegawai->id }}', '#usbk{{ $i }}', 'ujian_sekolah_berbasis_komputer');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->e_voting==1?"checked":"" }} id="evo{{ $i }}" onclick="check('{{ $pegawai->id }}', '#evo{{ $i }}', 'e_voting');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox-radios">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ $pegawai->access->konsultasi==1?"checked":"" }} id="konsultasi{{ $i }}" onclick="check('{{ $pegawai->id }}', '#konsultasi{{ $i }}', 'konsultasi');">
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- addons css --}}
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
    <style>
        .btn i {
            margin-right: 0px;
        }
    </style>
@endpush

{{-- addons js --}}
@push('js')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#order-table').DataTable();
        });

        function check(pegawai_id, id_check_form, structure){
            var isChecked = jQuery(id_check_form).is(":checked");
            $.ajax({
                url : "{{ route('admin.referensi.pengaturan-hak-akses-update') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    pegawai_id,
                    isChecked,
                    structure
                }
           //      ,
           //      success : function(data){
                    // $(id_check_form).attr("checked", "checked");
           //      },
           //      error : function(jqXHR, errorThrown, textStatus){
                    // swal({
                    //  title: "Failed!",
                    //  text: "Gagal Mengubah Akses",
                    //  type: "error",
                    //  buttonsStyling: false,
                    //  confirmButtonClass: "btn btn-danger"
                    // }).then(function(){
                    //  location.reload();
                    // });
           //      }
        });
        
    }
    </script>
@endpush