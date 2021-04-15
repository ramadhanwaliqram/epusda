@extends('layouts.guru')

{{-- config 1 --}}
@section('title', 'Sekolah | Kelas')
@section('title-2', 'Kelas')
@section('title-3', 'Kelas')

@section('describ')
    Ini adalah halaman kelas untuk guru
@endsection

@section('icon-l', 'fa fa-list-alt')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('guru.sekolah.kelas') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                                <thead class="text-left">
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Wali Kelas</th>
                                        <th>Kapasitas</th>
                                        <th>Jurusan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    {{-- @forelse($data ?? '' as $kelas)
                                        <tr>
                                            <td>{{ $kelas->name }}</td>
                                            <td>{{ $kelas->wali_kelas }}</td>
                                            <td>{{ $kelas->kapasitas }}</td>
                                            <td>{{ $kelas->jurusan }}</td>
                                            <td>{{ $kelas->keterangan }}</td>
                                            <td>
                                                <button type="button" data-id="{{$kelas->id}}" class="edit btn btn-mini btn-info shadow-sm">Edit</button>
                                                &nbsp;&nbsp;
                                                <button type="button" data-id="{{$kelas->id}}" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                                    @endforelse --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <h5 align="center" id="confirm">Apakah anda yakin ingin menghapus data ini?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-sm btn-outline-danger">Hapus</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
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
    <script src="{{ asset('bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('#order-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('guru.sekolah.kelas') }}",
                },
                columns: [
                    {data: 'name'},
                    {data: 'wali_kelas'},
                    {data: 'kapasitas'},
                    {data: 'jurusan'},
                    {data: 'keterangan'},
                ]
            });

            $('#form-kelas').on('submit', function (event) {
                event.preventDefault();
                var url = '';

                if ($('#action').val() == 'add') {
                    url = "{{ route('guru.sekolah.kelas') }}";
                    text = "Data sukses ditambahkan";
                }

                if ($('#action').val() == 'edit') {
                    url = "{{ route('guru.sekolah.kelas-update') }}";
                    text = "Data sukses diupdate";
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: $(this).serialize(),
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            // for (var count = 0; count <= data.errors.length; count++) {
                            html = data.errors[0];
                            // }
                            $('#name').addClass('is-invalid');
                            $('#tingkat').addClass('is-invalid');
                            $('#jurusan').addClass('is-invalid');
                            toastr.error(html);
                        }

                        if (data.success) {
                            toastr.success('Data sukses ditambahkan');
                            $('#name').removeClass('is-invalid');
                            $('#tingkat').removeClass('is-invalid');
                            $('#jurusan').removeClass('is-invalid');
                            $('#form-kelas')[0].reset();
                            $('#action').val('add');
                            $('#btn')
                                .removeClass('btn-outline-info')
                                .addClass('btn-outline-success')
                                .val('Simpan');
                            $('#order-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }
                });
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/guru/sekolah/kelas/'+id,
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data.kelas);
                        $('#name').val(data.kelas.name);
                        $('#tingkat').val(data.kelas.tingkatan_kelas_id);
                        $('#wali_kelas').val(data.kelas.pegawai_id);
                        $('#jurusan').val(data.kelas.jurusan_id);
                        $('#kapasitas').val(data.kelas.kapasitas);
                        $('#keterangan').val(data.kelas.keterangan);
                        $('#hidden_id').val(data.kelas.id);
                        $('#action').val('edit');
                        $('#btn')
                            .removeClass('btn-outline-success')
                            .addClass('btn-outline-info')
                            .val('Update');
                    }
                });
            });

            var user_id;
            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('data-id');
                $('#ok_button').text('Hapus');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: '/guru/sekolah/kelas/hapus/'+user_id,
                    beforeSend: function () {
                        $('#ok_button').text('Menghapus...');
                    }, success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#order-table').DataTable().ajax.reload();
                            toastr.success('Data berhasil dihapus');
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endpush
