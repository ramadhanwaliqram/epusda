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
                                    <th>Kabupaten</th>
                                    <th>Sekolah</th>
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
                                    <td>{{ $slider->kabupatenKota->name }}</td>
                                    <td>
                                        <ol>
                                            @foreach($slider->sekolah as $sekolah)
                                            <li>{{ $sekolah->name }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td>
                                        <a class="edit btn btn-mini btn-info shadow-sm" href='{{route('superadmin.slider.update-slider', $slider->id) }}'><i class="fa fa-pencil-alt"></i></a>
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
<script>
    $(document).ready(function() {

        $('#add').on('click', function() {
            $('#modal-slider').modal('show');
        });

        $('#order-table').DataTable();

        $('#sekolah').select2();


        $('#start_date').dateDropper({
            theme: 'leaf',
            format: 'd-m-Y'
        });

        $('#end_date').dateDropper({
            theme: 'leaf',
            format: 'd-m-Y'
        });

        // $('#order-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: {
        //         url: "{{ route('admin.e-voting.pemilihan') }}",
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
        //         data: 'posisi',
        //         name: 'posisi'
        //     },
        //     {
        //         data: 'start_date',
        //         name: 'start_date'
        //     },
        //     {
        //         data: 'end_date',
        //         name: 'end_date'
        //     },
        //     {
        //         data: 'action',
        //         name: 'action'
        //     }
        //     ],
        //     columnDefs: [
        //     {
        //         render: function (data, type, full, meta) {
        //             return "<div class='text-wrap width-200'>" + data + "</div>";
        //         },
        //         targets: 5
        //     }
        //     ]
        // });

        $("#kabupaten_kota").change(function() {
            _this = $(this);
            $.ajax({
                url: "{{ route('superadmin.referensi.kabupaten-kota-getSchools') }}",
                dataType: 'JSON',
                data: {
                    kabupaten_id: _this.val()
                },
                success: function(data) {
                    $("#sekolah").html("");
                    var options = "";
                    for (let key in data) {
                        options += `<option value="${data[key].id}">${data[key].name}</option>`;
                    }
                    $("#sekolah").html(options);
                }
            });
        });


        var id;
        $(document).on('click', '.edit-slider', function() {
            id = $(this).attr('id');
            $('#modal-slider-edit').modal('show');
            $.ajax({
                url: '/superadmin/slider/edit/' + 1,
                dataType: 'JSON',
                success: function(data) {
                    $('#action').val('edit');
                    $('#btn').removeClass('btn-outline-success').addClass('btn-outline-info').text('Update');
                    $('#nama_calon').val(data.name.name);
                    $('#posisi').val(data.posisi.posisi);
                    $('#start_date').val(data.start_date.start_date);
                    $('#end_date').val(data.end_date.end_date);
                    $('#hidden_id').val(data.name.id);
                    $('#modal-pemilihan').modal('show');
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
                url: '/superadmin/slider/' + user_id,
                beforeSend: function() {
                    $('#ok_button').text('Menghapus...');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        location.reload();
                        toastr.success('Data berhasil dihapus');
                    }, 1000);
                }
            });
        });

    });
</script>
@endpush