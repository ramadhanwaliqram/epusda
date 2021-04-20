@extends('layouts.superadmin')

@section('title', 'List User')
@section('title-2', 'List User')
@section('title-3', 'List User')
@section('describ')
    Ini adalah halaman List User untuk superadmin
@endsection
@section('icon-l', 'icon-home')
@section('icon-r', 'icon-home')
@section('link')
    {{ route('superadmin.list-user') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow">
            <div class="card-header">
                <h5>List User</h5>
            </div>
            <div class="card-body">
                <div class="card-block">
                    {{-- <button id="add" class="btn btn-outline-primary shadow-sm"><i class="fa fa-plus"></i></button> --}}
                    <div class="dt-responsive table-responsive">
                        <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Handphone/WA</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  $i = 1; ?>
                                @foreach ($users as $user)
                                <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_phone }}</td>
                                <td>{{ $user->status }}</td>
                                <td>
                                    <button type="button" id="{{$user->id}}" class="edit btn btn-mini btn-info shadow-sm"><i class="fa fa-pencil-alt"></i></button>
                                    &nbsp;
                                    <button type="button" id="{{$user->id}}" class="delete btn btn-mini btn-danger shadow-sm"><i class='fa fa-trash'></i></button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
@include('superadmin.modals._tambah-user')

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
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#order-table').DataTable();
            // $('#order-table').DataTable({
                // processing: true,
                // serverSide: true,
                // ajax: {
                //     url: "{{ route('superadmin.list-user') }}",
                // },
                // columns: [
                // {
                //     data: 'DT_RowIndex',
                //     name: 'DT_RowIndex'
                // },
                // {
                //     data: 'name',
                //     name: 'name'
                // },
                // {
                //     data: 'action',
                //     name: 'action'
                // }
                // ]
            // });

            $('#form-user').on('submit', function (e) {
                if ($('#action').val() == 'add') {
                    this.action = "{{ route('superadmin.list-user') }}";
                    this.method = "POST";
                    this.querySelector("input[name=_method]").value = "POST";
                }

                if ($('#action').val() == 'edit') {
                    this.action = "{{ route('superadmin.list-user-update') }}";
                    this.querySelector("input[name=_method]").value = "POST";
                }
                return;

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: $(this).serialize(),
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            for (var count = 0; count < data.errors.length; count++) {
                                html = data.errors[count];
                            }
                            $('#sekolah').addClass('is-invalid');
                            $('#id_sekolah').addClass('is-invalid');
                            $('#name').addClass('is-invalid');
                            $('#jenjang').addClass('is-invalid');
                            $('#tahun_ajaran').addClass('is-invalid');
                            $('#alamat').addClass('is-invalid');
                            $('#provinsi').addClass('is-invalid');
                            $('#kabupaten').addClass('is-invalid');
                            $('#username').addClass('is-invalid');
                            $('#password').addClass('is-invalid');
                            toastr.error(html);
                        }

                        if (data.success) {
                            toastr.success(data.success);
                            $('#modal-sekolah').modal('hide');
                            $('#id_sekolah').removeClass('is-invalid');
                            $('#name').removeClass('is-invalid');
                            $('#jenjang').removeClass('is-invalid');
                            $('#tahun_ajaran').removeClass('is-invalid');
                            $('#alamat').removeClass('is-invalid');
                            $('#provinsi').removeClass('is-invalid');
                            $('#kabupaten').removeClass('is-invalid');
                            $('#username').removeClass('is-invalid');
                            $('#password').removeClass('is-invalid');
                            $('#form-sekolah')[0].reset();
                            $('#action').val('add');
                            $('#btn').removeClass('btn-outline-info').addClass('btn-outline-success').text('Simpan');
                            $('#order-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }
                });
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                $.ajax({
                    url: '/superadmin/list-user/'+id,
                    dataType: 'JSON',
                    success: function (data) {
                        $('#action').val('edit');
                        $('#btn').removeClass('btn-outline-success').addClass('btn-outline-info').text('Update');
                        $('#id_sekolah').val(data.sekolah.id_sekolah);
                        $('#name').val(data.sekolah.name);
                        $('#jenjang').val(data.sekolah.jenjang);
                        $('#tahun_ajaran').val(data.sekolah.tahun_ajaran);
                        $('#alamat').val(data.sekolah.alamat);
                        $('#hidden_id').val(data.sekolah.id);
                        $('#username').val(data.user[0].username).attr('readonly', true);
                        $('#password').val(data.user[0].password).attr('readonly', true);
                        $('#modal-sekolah').modal('show');
                    }
                });
            });

            var user_id;
            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('#ok_button').text('Hapus');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: '/superadmin/list-user/hapus/'+user_id,
                    beforeSend: function () {
                        $('#ok_button').text('Menghapus...');
                    }, success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#order-table').DataTable().ajax.reload();
                            toastr.success(data.success);
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endpush
