@extends('layouts.guru')

{{-- config 1 --}}
@section('title', 'Pengumuman | Pesan')
@section('title-2', 'Pesan')
@section('title-3', 'Pesan')

@section('describ')
    Ini adalah halaman pesan untuk guru
@endsection

@section('icon-l', 'icon-bell')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('guru.pengumuman.pesan') }}
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
                                    @php
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
                                        <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @include('guru.pengumuman.modals._pesan')
@endsection

{{-- addons css --}}
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datedropper/css/datedropper.min.css') }}" />
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
        $(document).ready(function () {
            // $('#order-table').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: {
            //         url: "{{ route('admin.pengumuman.pesan') }}",
            //     },
            //     columns: [
            //         {data: 'DT_RowIndex'},
            //         {data: 'judul'},
            //         {data: 'message_time'},
            //         {data: 'created_at'},
            //         {data: 'start_date'},
            //         // {data: ''},
            //         {data: 'action'},
            //     ]
            // });
            try {
                @if (count($data) > 0)
                    $('#order-table').DataTable();
                @endif
            } catch(e) {
                console.error(e);
            }

            $('#add').on('click', function () {
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
        });

        $('input:radio[name="message_time"]').change(function(){
            if ($(this).is(':checked') && $(this).val() == 'Using Time') {
                $("#start_date").removeAttr('disabled', '');
                $("#end_date").removeAttr('disabled', '');
            }else{
                $("#start_date").attr('disabled', '');
                $("#end_date").attr('disabled', '');
            }
        });

        $('#form-pesan').on('submit', function (event) {
            event.preventDefault();
            var url = '';

            if ($('#action').val() == 'add') {
                url = "{{ route('guru.pengumuman.pesan') }}";
                text = "Data sukses ditambahkan";
            }

            if ($('#action').val() == 'edit') {
                url = "{{ route('guru.pengumuman.pesan-update') }}";
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
                        $('#judul').addClass('is-invalid');
                        $('#message').addClass('is-invalid');
                        toastr.error(html);
                    }

                    if (data.success) {
                        toastr.success('Data sukses ditambahkan');
                        $('#judul').removeClass('is-invalid');
                        $('#message').removeClass('is-invalid');
                        $('#form-pesan')[0].reset();
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
                url: '/guru/pengumuman/pesan/'+id,
                dataType: 'JSON',
                success: function (data) {
                    console.log(data.kelas);
                    $('#judul').val(data.kelas.judul);
                    $('#notifikasi').val(data.kelas.notifikasi);
                    $('#dashboard').val(data.kelas.dashboard);
                    $('#message_time').val(data.kelas.message_time);
                    $('#start_date').val(data.kelas.start_date);
                    $('#end_date').val(data.kelas.end_date);
                    $('#message').val(data.kelas.message);
                    $('#hidden_id').val(data.kelas.id);
                    $('#action').val('edit');
                    $('#btn')
                        .removeClass('btn-outline-success')
                        .addClass('btn-outline-info')
                        .val('Update');
                    $('#modal-pesan').modal('show');
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
                url: '/guru/pengumuman/pesan/hapus/'+user_id,
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
    </script>
@endpush
