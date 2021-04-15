@extends('layouts.guru')

{{-- config 1 --}}
@section('title', 'Pelajaran | Jadwal Pelajaran')
@section('title-2', 'Jadwal Pelajaran')
@section('title-3', 'Jadwal Pelajaran')

@section('describ')
    Ini adalah halaman jadwal pelajaran untuk guru
@endsection

@section('icon-l', 'fa fa-list-alt')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('guru.pelajaran.jadwal-pelajaran') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                      <form method="get" action="{{route('guru.pelajaran.jadwal-pelajaran')}}">
                        <div class="dt-responsive ">
                            <div class="row">
                                <div class="col">
                                    <label for="nama_calon">Tampil Jadwal</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="jk">Kelas</label>
                                    <select name="kelas_id" id="jk" class="form-control form-control-sm" required>
                                        <option disabled>-- Kelas --</option>
                                        @foreach($kelas as $obj)
                                          <option value="{{$obj->id}}">{{$obj->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="jk">Semester</label>
                                    <select name="semester" id="jk" class="form-control form-control-sm" required>
                                        <option disabled>-- Semester --</option>
                                        <option value="ganjil">Ganjil</option>
                                        <option value="genap">Genap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="agama">Tahun Ajaran</label>
                                    <select name="tahun_ajaran" id="agama" class="form-control form-control-sm" required>
                                        <option disabled>-- Tahun Ajaran --</option>
                                        @foreach($tahun_ajaran as $obj)
                                        <option value="{{$obj}}">{{$obj}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                  <input type="hidden" name="req" value="table">
                                <input type="submit" class="btn btn-sm btn-outline-success" value="Tampil" id="tampil">
                            </div>
                            </div>
                        </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="showjpcard">
        <div class="col-md-12">

        <div class="row">
          <div class="col-md-4">
            @include('guru.pelajaran.jadwal-pelajaran-table-hari', ['hari' => 'Senin', 'data' => $data['senin'] ?? []])
          </div>
          <div class="col-md-4">
            @include('guru.pelajaran.jadwal-pelajaran-table-hari', ['hari' => 'Selasa', 'data' => $data['selasa'] ?? []])
          </div>
          <div class="col-md-4">
            @include('guru.pelajaran.jadwal-pelajaran-table-hari', ['hari' => 'Rabu', 'data' => $data['rabu'] ?? []])
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            @include('guru.pelajaran.jadwal-pelajaran-table-hari', ['hari' => 'Kamis', 'data' => $data['kamis'] ?? []])
          </div>
          <div class="col-md-4">
            @include('guru.pelajaran.jadwal-pelajaran-table-hari', ['hari' => 'Jumat', 'data' => $data['jumat'] ?? []])
          </div>
          <div class="col-md-4">
            @include('guru.pelajaran.jadwal-pelajaran-table-hari', ['hari' => 'Sabtu', 'data' => $data['sabtu'] ?? []])
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
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <style>
        .btn i {
            margin-right: 0px;
        }
    </style>
@endpush

{{-- addons js --}}
@push('js')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#showjpcard');
            table.hide();

            @if(request()->req == 'table')
            table.show();
            @endif

            var resetForm = () => {
              $('select[name=kelas]').val("{{ $kelas[0] ?? null }}");
              $('select[name=mata_pelajaran_id]').val("{{ $mata_pelajaran[0]->id ?? null }}");
              $('select[name=hari]').val("senin");
              $('select[name=semester]').val("ganjil");
              $('select[name=tahun_ajaran]').val("{{ $tahun_ajaran[0] ?? null}}");
              $('textarea[name=keterangan]').val('');
              var $radios = $('input:radio[name=jam_pelajaran]');
              $radios.prop('checked', false);
              $radios.filter('[value=1]').prop('checked', true);
            };

            $("#reset-form").click(() => {
              resetForm();
            });

            $('#form-jadwal-pelajaran').on('submit', function (event) {
                event.preventDefault();
                var url = "{{ route('guru.pelajaran.jadwal-pelajaran.write') }}?req=write";
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: $(this).serialize(),
                    success: function (data) {
                        toastr.success('Data berhasil disimpan');
                        resetForm();
                        table.hide();
                    },
                    error: function(data) {
                      if(typeof data.responseJSON.message == 'string')
                        return Swal.fire('Error', data.responseJSON.message, 'error');
                      else if(typeof data.responseJSON == 'string')
                        return Swal.fire('Error', data.responseJSON, 'error');
                    }
                });
            });

            $("#showjpcard").on('click', '.btn-delete', function(ev, data) {
                var id = ev.currentTarget.getAttribute('data-id');
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apa anda yakin untuk menghapus data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('guru.pelajaran.jadwal-pelajaran.write') }}?req=delete&id=" + id,
                            cache: false,
                            method: "POST",
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                toastr.success('Data berhasil dihapus');
                                setTimeout(() => {
                                 window.location.reload();
                                }, 500)
                            },
                            error: function(data) {
                                if(typeof data.responseJSON.message == 'string')
                                    return Swal.fire('Error', data.responseJSON.message, 'error');
                                else if(typeof data.responseJSON == 'string')
                                    return Swal.fire('Error', data.responseJSON, 'error');
                            }
                        });
                    }
                    })
            });



        });
    </script>
@endpush
