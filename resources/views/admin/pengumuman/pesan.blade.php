@extends('layouts.admin')

{{-- config 1 --}}
@section('title', 'Pengumuman | Pesan')
@section('title-2', 'Pesan')
@section('title-3', 'Pesan')

@section('describ')
Ini adalah halaman pesan untuk admin
@endsection

@section('icon-l', 'icon-bell')
@section('icon-r', 'icon-home')

@section('link')
{{ route('admin.pengumuman.pesan') }}
@endsection

{{-- main content --}}
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="card-block">
                    <button id="add" class="btn btn-outline-primary shadow-sm"><i class="fa fa-plus"></i></button>
                    <div class="dt-responsive table-responsive">
                        <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                            <thead class="text-left">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Set Waktu</th>
                                    <th>Tanggal Upload</th>
                                    <th>Tampil Pada</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                                {{-- @php
                                        $i = 1;
                                    @endphp
                                    @forelse($data as $pesan)
                                        <tr>
                                            <td>{{ $i }}</td>
                                <td>{{ $pesan->judul }}</td>
                                <td>{{ $pesan->message_time }}</td>
                                <td>{{ date("Y-m-d", strtotime($pesan->created_at)) }}</td>
                                <td>{{ $pesan->start_date }}</td>
                                <td>{{ $pesan->status }}</td>
                                <td>
                                    <button type="button" data-id="{{$pesan->id}}" class="edit btn btn-mini btn-info shadow-sm">Edit</button>
                                    &nbsp;&nbsp;
                                    <button type="button" data-id="{{$pesan->id}}" class="delete btn btn-mini btn-danger shadow-sm">Delete</button>
                                </td>
                                </tr>
                                @php
                                $i++;
                                @endphp
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div iv id="confirmModal" class="modal fade" role="dialog">
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

{{-- Modal --}}
@include('admin.pengumuman.modals._pesan')
{{-- @include('components.modals._confirm-delete-modal') --}}
@endsection

{{-- addons css --}}
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/data-table/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datedropper/css/datedropper.min.css') }}" />
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
<script src="{{ asset('bower_components/datedropper/js/datedropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#order-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.pengumuman.pesan') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'judul',
                    name: 'judul'
                },
                {
                    data: 'message_time',
                    name: 'message_time'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
        $('input:radio[name="message_time"]').change(function() {
            if ($(this).is(':checked') && $(this).val() == 'Using Time') {
                $("#start_date").removeAttr('disabled', '');
                $("#end_date").removeAttr('disabled', '');
            } else {
                $("#start_date").attr('disabled', '');
                $("#end_date").attr('disabled', '');
            }
        });

        $('#add').on('click', function() {
            $('.modal-title').html('Tambah Pesan');
            $('#judul').val('');
            $('#message').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            $('#action').val('add');
            $('#button')
                .removeClass('btn-outline-success edit')
                .addClass('btn-outline-info add')
                .html('Simpan');
            $('#modal-pesan').modal('show');
        });

        $('#start_date').dateDropper({
            theme: 'leaf',
            format: 'Y-m-d'
        });

        $('#end_date').dateDropper({
            theme: 'leaf',
            format: 'Y-m-d'
        });



        $('#form-pesan').on('submit', function(event) {
            event.preventDefault();
            var url = '';
            var atribut = $(this).attr("action");
            console.log(atribut)
            if ($('#button').hasClass('add')) {
                url = "{{ route('admin.pengumuman.pesan') }}";
                text = "Data sukses ditambahkan";
            }

            if ($('#button').hasClass('edit')) {
                url = "{{ route('admin.pengumuman.pesan-update') }}";
                text = "Data sukses diupdate";
            }
            console.log($(this).serialize());
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
                success: function(data) {
                    var html = '';
                    if (data.errors) {
                        // for (var count = 0; count <= data.errors.length; count++) {
                        html = data.errors[0];
                        // }
                        $('#judul').addClass('is-invalid');
                        $('#message').addClass('is-invalid');
                        toastr.error(html);
                    }

                    if (data.success) {
                        toastr.success('Data sukses ditambahkan');
                        $('#judul').removeClass('is-invalid');
                        $('#message').removeClass('is-invalid');
                        $('#modal-pesan').modal('hide');
                        $('#form-pesan')[0].reset();
                        $('#form-pesan form').attr('action', 'edit');
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



        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');

            $.ajax({
                url: '/admin/pengumuman/pesan/' + id,
                dataType: 'JSON',
                success: function(data) {
                    $('.modal-title').html('Edit Pesan');
                    $('#form-pesan form').attr('action', 'edit');
                    $('#judul').val(data.kelas.judul);
                    $('#message').val(data.kelas.message);
                    $('#start_date').val(data.kelas.start_date);
                    $('#end_date').val(data.kelas.end_date);
                    $('#hidden_id').val(data.kelas.id);
                    $('#action').val('edit');
                    $('#button')
                        .removeClass('btn-outline-success add')
                        .addClass('btn-outline-info edit')
                        .html('Update');
                    $('#modal-pesan').modal('show');
                }

            });
        });

        var user_id;
        $(document).on('click', '.delete', function() {
            user_id = $(this).attr('id');
            $('#ok_button').text('Hapus');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: '/admin/pengumuman/pesan/hapus/' + user_id,
                beforeSend: function() {
                    $('#ok_button').text('Menghapus...');
                },
                success: function(data) {
                    setTimeout(function() {
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