@extends('layouts.superadmin')

{{-- config 1 --}}
@section('title', 'Slider')
@section('title-2', 'Slider')
@section('title-3', 'Slider')

@section('describ')
Ini adalah halaman slider untuk Superadmin
@endsection

@section('icon-l', 'icon-list')
@section('icon-r', 'icon-home')

@section('link')
{{ route('superadmin.slider') }}
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
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Keterangan</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                                @foreach($sliders as $slider)
                                <tr>
                                    <td><img src="{{ asset("storage/$slider->foto") }}" width="100px"></td>
                                    <td>{{ $slider->judul }}</td>
                                    <td>{{ $slider->keterangan }}</td>
                                    <td>{{ $slider->start_date }}</td>
                                    <td>{{ $slider->end_date }}</td>
                                    <td>
                                        <button type="button" id="{{$slider->id}}" class="edit btn btn-mini btn-info shadow-sm"><i class="fa fa-pencil-alt"></i></button>
                                        &nbsp;
                                        <button type="button" id="{{$slider->id}}" class="delete btn btn-mini btn-danger shadow-sm"><i class='fa fa-trash'></i></button>
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
@include('superadmin.modals._slider')
@endsection

{{-- addons css --}}
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/data-table/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
<!-- Select 2 css -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/css/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datedropper/css/datedropper.min.css') }}" />
<style>
    .btn i {
        margin-right: 0px;
    }

    .select2-container {
        width: 100% !important;
        padding: 0;
    }
</style>
@endpush

{{-- addons js --}}
@push('js')
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Select 2 js -->
<script type="text/javascript" src="{{ asset('bower_components/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('bower_components/datedropper/js/datedropper.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script>
    $(document).ready(function () {

        $('#add').on('click', function () {
            $('.modal-slider').html('Tambah Slider');
            $('#action').val('add');
            $('#judul').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            $('#keterangan').val('');
            $('#btn')
                .removeClass('btn-info')
                .addClass('btn-success')
                .val('Simpan');
            $('#modal-slider').modal('show');
        });

        $('#start_date').dateDropper({
            theme: 'leaf',
            format: 'Y-m-d'
        });
        $('#end_date').dateDropper({
            theme: 'leaf',
            format: 'Y-m-d'
        });

        $('#order-table').DataTable();

        $('#form-slider').on('submit', function (event) {
            event.preventDefault();

            var url = '';
            if ($('#action').val() == 'add') {
                url = "{{ route('superadmin.slider') }}";
            }

            if ($('#action').val() == 'edit') {
                url = "{{ route('superadmin.slider.slider-update') }}";
            }

            var formData = new FormData($('#form-slider')[0]);

            $('#btn').prop('disabled', true);

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
                        $('#start_date').addClass('is-invalid');
                        $('#end_date').addClass('is-invalid');
                        $('#keterangan').addClass('is-invalid');
                        toastr.error(html);
                        $('#btn').prop('disabled', false);
                    }

                    if (data.success) {
                        // toastr.success('Sukses!');

                        if ($('#action').val() == 'add') {
                            toastr.success('Data berhasil ditambahkan');
                        }

                        if ($('#action').val() == 'edit') {
                            toastr.success('Data berhasil diubah');
                        }
                        
                        $('#modal-slider').modal('hide');
                        $('#judul').removeClass('is-invalid');
                        $('#start_date').removeClass('is-invalid');
                        $('#end_date').removeClass('is-invalid');
                        $('#keterangan').removeClass('is-invalid');
                        $('#form-slider')[0].reset();
                        $('#action').val('add');
                        $('#btn').prop('disabled', false);
                        $('#btn')
                            .val('Simpan');
                        location.reload();
                        // $('#order-table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                },
                error: function(errors){
                    toastr.error('Error');
                    $('#btn').prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.edit', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '/superadmin/slider/'+id,
                dataType: 'JSON',
                success: function (data) {
                    $('#action').val('edit');
                    $('#judul').val(data.judul);
                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);
                    $('#keterangan').val(data.keterangan);
                    $('#hidden_id').val(data.id);
                    $('#btn')
                        .removeClass('btn-success')
                        .addClass('btn-info')
                        .val('Update');
                    $('#modal-slider').modal('show');
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
                url: '/superadmin/slider/hapus/'+user_id,
                beforeSend: function () {
                    $('#ok_button').text('Menghapus...');
                }, success: function (data) {
                    setTimeout(function () {
                        $('#confirmModal').modal('hide');
                        toastr.success('Data berhasil dihapus');
                        location.reload();
                        // $('#order-table').DataTable().reload();
                    }, 1000);
                }
            });
        });

    });
</script>
@endpush