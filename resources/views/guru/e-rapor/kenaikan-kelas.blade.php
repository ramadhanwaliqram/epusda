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
                                    <form action="">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <select name="pilih" id="pilih" class="form-control form-control-sm">
                                                    <option value="">-- Kelas --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary mt-3">Filter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input position-static" type="checkbox" name="kelas" id="kelas" aria-label="...">
                                        <label class="form-check-label ml-2" for="kelas">Asdf</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <h6>Naik ke Kelas</h6>
                                        <form action="">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <select name="pilih" id="pilih" class="form-control form-control-sm">
                                                        <option value="">-- Kelas --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-success mt-3">Simpan</button>
                                            <button type="button" class="btn btn-danger mt-3">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection