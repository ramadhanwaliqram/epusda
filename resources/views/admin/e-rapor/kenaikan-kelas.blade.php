@extends('layouts.admin')

{{-- config 1 --}}
@section('title', 'E-Rapor | Kenaikan Kelas')
@section('title-2', 'Kenaikan Kelas')
@section('title-3', 'Kenaikan Kelas')

@section('describ')
    Ini adalah halaman Kenaikan Kelas untuk admin
@endsection

@section('icon-l', 'fa fa-file-alt')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('admin.e-rapor.kenaikan-kelas') }}
@endsection

{{-- main content --}}
@section('content')
<div class="row">

    <div class="col-xl-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-block">
                            <h6>Kelas</h6>
                            <div class="col-xl-6 px-0">
                                <form id="form-get">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <select name="pilih1" id="pilih-kelas1" class="form-control form-control-sm">
                                                <option value="" disabled selected>-- Kelas --</option>
                                                @foreach($kelases as $kelas)

                                                <option class="op-kelas" value="{{ $kelas->id }}">{{ $kelas->name }} - {{$kelas->tingkatan_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3 btn-filter">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="post" action="{{route('admin.e-rapor.kenaikan-kelas.add')}}" id="form-pindah">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">

                                <div class="card-body">
                                    @foreach($data as $d)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input position-static input-siswa" type="checkbox" value="{{$d->id}}" name="nama_siswa[]" id="kelas" aria-label="...">
                                        <label class="form-check-label ml-2" for="kelas">{{$d->nama_lengkap}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <h6>Naik ke Kelas</h6>

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <select name="kelas2" id="pilih-kelas2" class="form-control form-control-sm">
                                                    <option value="" disabled selected>-- Kelas --</option>
                                                    @foreach($kelases as $kelas)
                                                    <option value="{{ $kelas->id }}">{{ $kelas->name }} - {{$kelas->tingkatan_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline-success mt-3 btn-pindah">Simpan</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- addon js --}}
@push('js')
<script>
    $(document).ready(function() {

        $('#btn-filter').on('click', function(event) {
            $.ajax({
                url: "{{route('admin.e-rapor.kenaikan-kelas.get')}}",
                method: 'POST',
                dataType: 'JSON',
                data: $('#pilih-kelas1').val(),
                success: function(data) {
                    location.reload()
                }
            });
        });



    })
</script>
@endpush
