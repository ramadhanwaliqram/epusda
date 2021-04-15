@extends('layouts.superadmin')

{{-- config 1 --}}
@section('title', 'Slider')
@section('title-2', 'Slider')
@section('title-3', 'Slider')

@section('describ')
Ini adalah halaman Slider untuk Superadmin
@endsection

@section('icon-l', 'icon-book')
@section('icon-r', 'icon-home')

@section('link')
{{ route('superadmin.slider') }}
@endsection

@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow">
            <div class="card-header">
                <h5>Edit Slider | {{ $slider->judul }}</h5>
            </div>
            <div class="card-body">
                <form id="form-slider" method="POST" action="{{ route('superadmin.slider.update', $slider->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" name="judul" id="judul" class="form-control form-control-sm" value="{{ $slider->judul }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="posisi">Kabupaten / Kota</label>
                                <select name="kabupaten_kota" id="kabupaten_kota" class="form-control form-control-sm">
                                    <option value="">Pilih</option>
                                    <?php
                                    foreach ($cities as $city) {
                                    ?>
                                        <option value="<?= $city->id ?>"><?= $city->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="sekolah">Sekolah</label>
                                <select name="sekolah[]" id="sekolah" class="form-control form-control-sm" multiple>
                                    <option value="">-- Pilih Kabupaten Dahulu --</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input id="start_date" value="{{$slider->start_date}}" name="start_date" class="form-control form-control-sm" type="text" placeholder="Start Date" readonly />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input id="end_date" value="{{$slider->end_date}}" name="end_date" class="form-control form-control-sm" type="text" placeholder="End Date" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" value="" id="keterangan" cols="10" rows="3" class="form-control form-control-sm" placeholder="Keterangan">{{$slider->keterangan}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <img src="{{ asset("storage/$slider->foto") }}" width="200px">
                                <input type="file" class="form-control form-control-sm mt-3" name="foto" id="foto" accept="image/*" value="" autocomplete="off">
                                <label for="foto" class="mt-1">
                                    thumbnail:
                                    <small class="text-muted">max. 3MB</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-outline-success">Ubah</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- addons css --}}
@push('css')
<link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datedropper/css/datedropper.min.css') }}" />
<link rel="stylesheet" href="{{ asset('bower_components/select2/css/select2.min.css') }}" />

<style>
    .btn i {
        margin-right: 0px;
    }
</style>
@endpush

{{-- addons js --}}
@push('js')
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('bower_components/datedropper/js/datedropper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#sekolah').select2();


        $('#start_date').dateDropper({
            theme: 'leaf',
            format: 'd-m-Y'
        });

        $('#end_date').dateDropper({
            theme: 'leaf',
            format: 'd-m-Y'
        });

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
    });
</script>
@endpush