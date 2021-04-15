@extends('layouts.superadmin')

{{-- config 1 --}}
@section('title', 'Berita')
@section('title-2', 'Berita')
@section('title-3', 'Berita')

@section('describ')
    Ini adalah halaman Berita untuk Superadmin
@endsection

@section('icon-l', 'icon-book')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('superadmin.berita.berita') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <button id="add" class="btn btn-outline-primary shadow-sm"><i class="fa fa-plus"></i></button>
                        <div class="dt-responsive table-responsive mt-3">
                            <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                                <thead class="text-left">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tanggal Rilis</th>
                                        <th>Thumbnail</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    @foreach($data as $dt)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{$dt->name}}</td>
                                        <td>{{$dt->kategori}}</td>
                                        <td>{{$dt->tanggal_rilis}}</td>
                                        <td><a target="_blank" href="{{Storage::url($dt->thumbnail)}}">Lihat Foto</a></td>
                                        <td>
                                            <a class="edit btn btn-mini btn-info shadow-sm" href='{{route('superadmin.berita.edit', $dt->id) }}'><i class="fa fa-pencil-alt"></i></a>
                                            &nbsp;
                                            <button type="button" id="{{$dt->id}}" class="delete btn btn-mini btn-danger shadow-sm"><i class='fa fa-trash'></i></button>
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

    {{-- Modal --}}
    @include('superadmin.berita.modals._berita')
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
        $(document).ready(function () {

            $('#add').on('click', function () {
                $('#modal-berita').modal('show');
            });

            $('#tanggal_rilis').dateDropper({
                theme: 'leaf',
                format: 'd-m-Y'
            });

            $('#order-table').DataTable();

            // $('#order-table').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: {
            //         url: "{{ route('superadmin.berita.berita') }}",
            //     },
            //     columns: [
            //     {
            //         data: 'DT_RowIndex',
            //         name: 'DT_RowIndex'
            //     },
            //     {
            //         data: 'name',
            //         name: 'name'
            //     },
            //     {
            //         data: 'kategori',
            //         name: 'kategori'
            //     },
            //     {
            //         data: 'isi',
            //         name: 'isi'
            //     },
            //     {
            //         data: 'thumbnail',
            //         name: 'thumbnail'
            //     },
            //     {
            //         data: 'action',
            //         name: 'action'
            //     }
            //     ]
            // });

            $('#form-berita').on('submit', function (event) {
                event.preventDefault();

                var url = '';
                if ($('#judul').val() == 'add') {
                    url = "{{ route('superadmin.berita.berita') }}";
                }

                if ($('#action').val() == 'edit') {
                    url = "{{ route('superadmin.berita.berita-update') }}";
                }

                var formData = new FormData($('#form-berita')[0]);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        var html = ''
                        if (data.errors) {
                            html = data.errors[0];
                            $('#judul').addClass('is-invalid');
                            toastr.error(html);
                        }

                        if (data.success) {
                            toastr.success('Sukses!');
                            $('#modal-berita').modal('hide');
                            $('#judul').removeClass('is-invalid');
                            $('#form-berita')[0].reset();
                            $('#action').val('add');
                            $('#btn')
                                .removeClass('btn-outline-info')
                                .addClass('btn-outline-success')
                                .val('Simpan');
                            location.reload();
                            // $('#order-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
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
                    url: '/superadmin/berita/berita/hapus/'+user_id,
                    beforeSend: function () {
                        $('#ok_button').text('Menghapus...');
                    }, success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            location.reload();
                            // $('#order-table').DataTable().ajax.reload();
                            toastr.success('Data berhasil dihapus');
                        }, 1000);
                    }
                });
            });

        });
    </script>
@endpush