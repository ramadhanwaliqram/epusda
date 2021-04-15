@extends('layouts.admin')

@section('title', 'Dashboard')
@section('title-2', 'Dashboard')
@section('title-3', 'Dashboard')
@section('describ')
    Ini adalah halaman dashboard awal untuk admin
@endsection
@section('icon-l', 'icon-home')
@section('icon-r', 'icon-home')
@section('link')
    {{ route('admin.index') }}
@endsection

@section('content')
<div class="row">
    {{-- sale revenue card start --}}
    <div class="col-md-12 col-xl-8">
        <div class="card sale-card">
            <div class="card-header">
                <h5>Grafik</h5>
            </div>
            <div class="card-block">
                <div id="sales-analytics" class="chart-shadow" style="height:380px"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-25">E-Book</h6>
                        <h3 class="f-w-700 text-c-blue">{{ $ebook }}</h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-open bg-c-blue"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-25">Audio Book</h6>
                        <h3 class="f-w-700 text-c-green">{{ $audiobook }}</h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-audio bg-c-green"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-25">Video Book</h6>
                        <h3 class="f-w-700 text-c-yellow">{{ $videobook }}</h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-video bg-c-yellow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-25">Siswa</h6>
                        <h3 class="f-w-700 text-c-blue">{{ $siswa }}</h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user bg-c-blue"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-25">Guru</h6>
                        <h3 class="f-w-700 text-c-green">{{ $guru }}</h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user bg-c-green"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card comp-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-b-25">Orang Tua</h6>
                        <h3 class="f-w-700 text-c-yellow">{{ $orangtua }}</h3>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user bg-c-yellow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Project statustic start --}}


        {{-- <div class="card proj-progress-card">
            <div class="card-block">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <h6>Siswa</h6>
                        <h5 class="m-b-30 f-w-700">{{ $siswa }}</h5>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <h6>Guru</h6>
                        <h5 class="m-b-30 f-w-700">{{ $guru }}</h5>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <h6>Orang Tua</h6>
                        <h5 class="m-b-30 f-w-700">{{ $orangtua }}</h5>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- testimonial and top selling start --}}
    {{-- <div class="col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Leaderboard</h5>
            </div>
            <div class="card-block p-b-0">
                <div class="table-responsive">
                    <table class="table table-hover m-b-0">
                        <thead>
                            <tr>
                                <th>PML</th>
                                <th>PMI</th>
                                <th>Nama</th>
                                <th>Audio Book</th>
                                <th>Video Book</th>
                                <th>E-Book</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>13</td>
                                <td>Syafri</td>
                                <td>{{ rand(10,1000) }}</td>
                                <td>{{ rand(10,1000) }}</td>
                                <td>{{ rand(10,1000) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<div class="row">

</div>

@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard/custom-dashboard.min.js') }}"></script>
@endpush
