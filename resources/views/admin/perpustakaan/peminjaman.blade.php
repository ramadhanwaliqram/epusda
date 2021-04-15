@extends('layouts.admin')

@section('title', 'List Peminjam')
@section('title-2', 'List Peminjam')
@section('title-3', 'List Peminjam')
@section('describ')
Ini adalah halaman list peminjam untuk admin
@endsection
@section('icon-l', 'icon-home')
@section('icon-r', 'icon-home')
@section('link')
{{ route('admin.perpustakaan.list-peminjam') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow">
            <div class="card-header">
                <h5>List Peminjam</h5>
            </div>
            <div class="card-body">
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Judul Buku</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($data as $d)
                                <td>{{$i++}}</td>
                                <td>{{$d->nama_lengkap}}</td>
                                <td>{{$d->name}}</td>
                                <td>@if (!$d->audio_expired_at == '')
                                    <button type='button' class='ml-2 delete btn btn-mini btn-primary shadow-sm'><i class='far fa-file-audio'></i></button>
                                    @else

                                    @endif

                                    @if(!$d->ebook_expired_at == '')
                                    <button type='button' class='ml-2 delete btn btn-mini btn-info shadow-sm'><i class='fas fa-book'></i></button>
                                    @else

                                    @endif

                                    @if (!$d->video_expired_at == '')
                                    <button type='button' class='ml-2 delete btn btn-mini btn-danger shadow-sm'><i class='far fa-file-video'></i></button>
                                    @else

                                    @endif
                                </td>
                                @endforeach
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
    $('document').ready(function() {
        $('#order-table').DataTable();
    })
</script>
@endpush