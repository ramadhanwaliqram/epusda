@extends('layouts.guru')

{{-- config 1 --}}
@section('title', 'Pelajaran | Mata Pelajaran')
@section('title-2', 'Mata Pelajaran')
@section('title-3', 'Mata Pelajaran')

@section('describ')
    Ini adalah halaman mata pelajaran untuk guru
@endsection

@section('icon-l', 'fa fa-list-alt')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('guru.pelajaran.mata-pelajaran') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                                <thead class="text-left">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelajaran</th>
                                        <th>Guru</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">

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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var resetForm = () => {
                $('input[name=id]').val('');
                $('input[name=nama_pelajaran]').val('');
                $('input[name=kode_pelajaran]').val('');
                $('select[name=guru_id]').val('');
                $('input[name=keterangan]').val('');
                $('input[name=aktif]').prop('checked', true);
                $('#btn').val('Simpan');
            }

            var form = $('#form-pelajaran');

            var table = $('#order-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.pelajaran.mata-pelajaran') }}?req=table",
                columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_pelajaran',
                },
                {
                    data: 'nama_guru',
                    name: 'nama_guru'
                },
                {
                    data: 'aktif',
                    render: (data) =>  data == 1 ? 'Aktif' : 'Non Aktif'
                },
                {
                    data: 'id',
                    render: (id) => {
                        return `<button data-id="${id}" type="button" class="btn btn-edit btn-mini btn-info shadow-sm">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>&nbsp;&nbsp;
                                <button data-id="${id}" type="button" class="btn btn-delete btn-mini btn-danger shadow-sm" data-toggle="modal" data-target="#confirmDeleteModal">
                                    <i class="fa fa-trash"></i>
                                </button>`;
                    }
                }
                ]
            });

            $('#form-pelajaran').on('submit', function (event) {
                event.preventDefault();
                var url = "{{ route('admin.pelajaran.mata-pelajaran.write') }}?req=write";
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: $(this).serialize(),
                    success: function (data) {
                        toastr.success('Data sukses ditambahkan');
                        resetForm();
                        table.ajax.reload();
                    },
                    error: function(data) {
                        if(typeof data.responseJSON.message == 'string')
                                    return Swal.fire('Error', data.responseJSON.message, 'error');
                                else if(typeof data.responseJSON == 'string')
                                    return Swal.fire('Error', data.responseJSON, 'error');
                    }
                });
            });

            $('#order-table').on('click', '.btn-edit', function (ev, data) {
                var id = ev.currentTarget.getAttribute('data-id');
                $.get("{{route('admin.pelajaran.mata-pelajaran')}}?req=single&id=" + id, function (data, status){
                    $('input[name=id]').val(data.id);
                    $('input[name=nama_pelajaran]').val(data.nama_pelajaran);
                    $('input[name=kode_pelajaran]').val(data.kode_pelajaran);
                    $('input[name=keterangan]').val(data.keterangan);
                    $('input[name=aktif]').prop('checked', data.aktif == 1);
                    $('select[name=guru_id]').val(data.guru_id);
                    $('#btn').val('Update');
                });
            });

            $('#reset').click(() => {
                resetForm();
            });

            $("#order-table").on('click', '.btn-delete', function(ev, data) {
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
                            url: "{{ route('admin.pelajaran.mata-pelajaran.write') }}?req=delete&id=" + id,
                            cache: false,
                            method: "POST",
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                toastr.success('Data berhasil dihapus');
                                table.ajax.reload();
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
