@extends('layouts.admin')

{{-- config 1 --}}
@section('title', 'Daftar Nilai | Daftar Nilai')
@section('title-2', 'Daftar Nilai')
@section('title-3', 'Daftar Nilai')

@section('describ')
Ini adalah halaman Daftar Nilai untuk admin
@endsection

@section('icon-l', 'fa fa-medal')
@section('icon-r', 'icon-home')

@section('link')
{{ route('admin.daftar-nilai') }}
@endsection

{{-- main content --}}

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="card-block">
                    <h6>Filter</h6>
                    <form id="form-daftar-nilai" action="{{route('admin.daftar-nilai')}}" method="GET">
                        <input type="hidden" name="req" value="table">
                        <div class="row">
                            <div class="col-xl-2">
                                <select name="kelas_id" id="pilih" class="form-control form-control-sm" required>
                                    <option value="">-- Kelas --</option>
                                    @foreach($kelas as $obj)
                                    <option value="{{$obj->id}}" {{ request()->kelas_id == $obj->id ? 'selected' : '' }}>{{$obj->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-control form-control-sm">
                                    <option value="">-- Pelajaran --</option>
                                    @foreach($pelajaran as $obj)
                                    <option value="{{$obj->id}}">{{$obj->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control form-control-sm">
                                    <option value="">-- Tahun Ajaran --</option>
                                    <option value="2019/2020">2019/2020</option>
                                    <option value="2020/2021">2020/2021</option>
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <select name="semester" id="semester" class="form-control form-control-sm">
                                    <option value="">-- Semester --</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <select name="kategori_nilai" id="kategori_nilai" class="form-control form-control-sm">
                                    <option value="">-- Kategori Nilai --</option>
                                    <option value="UH">UH</option>
                                    <option value="UTS">UTS</option>
                                    <option value="UAS">UAS</option>
                                    <option value="Tugas">Tugas Harian</option>
                                    <option value="Praktek">Praktek</option>
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <input type="submit" value="Pilih" class="btn btn-block btn-sm btn-primary shadow-sm">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="order-table" class="table table-striped table-bordered nowrap shadow-sm">
                            <thead class="text-left">
                                <tr class="tr1">
                                    <th style="vertical-align: middle">Nama Siswa</th>
                                    <th style="vertical-align: middle">Pelajaran</th>
                                    <th style="vertical-align: middle">Guru</th>
                                    @for ($i = 1; $i <= $jumlah_data; $i++)
                                        @if ($i==1)
                                        <th style="width: 15%; vertical-align: middle">{{ request()->kategori_nilai }} {{ $i }}
                                            <button id="btnTambahNilai" class="btn btn-outline-primary btn-sm shadow-sm"><i class="fa fa-plus"></i></button>
                                        </th>
                                        @else
                                        <th id="cells_<?php echo $i; ?>" style="width: 15%; vertical-align: middle">{{ request()->kategori_nilai }} {{ $i }}
                                            @if ($i == $jumlah_data)
                                            <button class="btn btn-outline-danger btn-sm btn-sm shadow-sm" onclick="remove_cells('<?php echo $i; ?>');"><i class="fa fa-times"></i></button>
                                            @endif
                                        </th>
                                        @endif
                                        @endfor
                                        <th style="width: 15%; vertical-align: middle" id="nr_cell">NR</th>
                                        <th style="vertical-align: middle">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                                @foreach($data_siswa as $obj)
                                {{-- <form class="form-daftar-nilai" method="post" action="{{ route('admin.daftar-nilai.store') }}"> --}}
                                @method('POST')
                                @csrf
                                <input type="hidden" name="siswa_id" value="{{$obj->id}}">
                                <input type="hidden" name="kelas_id" value="{{ request()->kelas_id }}">
                                <input type="hidden" name="tahun_ajaran" value="{{ request()->tahun_ajaran }}">
                                <input type="hidden" name="kategori_nilai" value="{{ request()->kategori_nilai }}">
                                <input type="hidden" name="mata_pelajaran_id" value="{{ request()->mata_pelajaran_id }}">
                                <input type="hidden" name="semester" value="{{ request()->semester }}">
                                <tr>
                                    <td>{{ $obj->nama_lengkap}}</td>
                                    {{-- @foreach ($pelajaran as $pl) --}}
                                    <td class="text-center">{{ $data_pelajaran->nama_pelajaran ?? ''}}</td>
                                    <td class="text-center">{{ $data_pelajaran->guru->pegawai->name ?? ''}}</td>
                                    {{-- @endforeach --}}
                                    @php
                                    $totalNilai=0;
                                    $nilai = $obj->nilai
                                    ->where('kelas_id',request()->kelas_id)
                                    ->where('mata_pelajaran_id',request()->mata_pelajaran_id)
                                    ->where('tahun_ajaran',request()->tahun_ajaran)
                                    ->where('semester',request()->semester)
                                    ->where('kategori_nilai',request()->kategori_nilai);
                                    // dd($obj->nilai
                                    // ->where('kelas_id',request()->kelas_id)
                                    // ->where('mata_pelajaran_id',request()->mata_pelajaran_id)
                                    // ->where('tahun_ajaran',request()->tahun_ajaran)
                                    // ->where('semester',request()->semester)
                                    // ->where('kategori_nilai',request()->kategori_nilai)
                                    // );
                                    @endphp
                                    @for ($j = 1; $j <= $jumlah_data; $j++) @php $totalNilai +=$nilai[$j-1]->nilai;
                                        @endphp
                                        <td id="cells_{{ $obj->id."_".$j }}"><input type="number" max="100" class="form-control" name="{{ "nilai_".$j."_".$obj->id }}" id="{{"nilai_".$j."_".$obj->id}}" onchange="nilai_changed('{{ $obj->id }}')" value="{{ $nilai[$j-1]->nilai??"" }}"></td>
                                        {{-- <td><input type="number" id="nilai{{$obj->id}}" name="nilai[]" class="form-control form-control-sm" onchange="nilai_changed('{{ $obj->id }}')" value=""></td> --}}
                                        @endfor

                                        @php
                                        $total = $totalNilai / $jumlah_data;
                                        @endphp
                                        <td id="nr_cells_{{$obj->id}}"><input type="text" name="nilai_average_{{ $obj->id }}" class="form-control form-control-sm" disabled id="nilai_average_{{ $obj->id }}" value="{{ $total??"" }}"></td>
                                        <td id="submit_{{$obj->id}}" class="text-center">
                                            {{-- @if($obj->nilai) --}}
                                            {{-- APPROVE --}}
                                            {{-- @else --}}
                                            <input type="hidden" id="action" val="add">
                                            <button class="btn btn-success disabled" type="submit" onclick="nilai_select('{{ $obj->id }}')" id="btn_approve_{{ $obj->id }}">Approve</button>
                                            {{-- <input type="submit" class="btn btn-success" value="approve"> --}}
                                            {{-- @endif --}}
                                        </td>
                                </tr>
                                {{-- </form> --}}
                                @endforeach
                            </tbody>
                            <input type="hidden" id="total_form" name="total_form" value="{{ $jumlah_data }}">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script>
    var tr = document.querySelector('.tr1');
    var newTH = document.createElement('th');
    newTH.innerHTML = 'Tes';

    function addNilai() {
        tr.appendChild(newTH);
    }

    function nilai_select(siswa_id) {
        var total = $("#total_form").val();
        var kelas_id = "<?php echo $_GET['kelas_id'] ?? ""; ?>";
        var mata_pelajaran_id = "<?php echo $_GET['mata_pelajaran_id'] ?? ""; ?>";
        var tahun_ajaran = "<?php echo $_GET['tahun_ajaran'] ?? ""; ?>";
        var semester = "<?php echo $_GET['semester'] ?? ""; ?>";
        var kategori_nilai = "<?php echo $_GET['kategori_nilai'] ?? ""; ?>";
        var i;
        var nilai;

        //Memulai memasukkan nilai
        for (i = 1; i <= total; i++) {
            nilai = $("#nilai_" + i + "_" + siswa_id).val();
            $.ajax({
                url: "{{ route('admin.daftar-nilai.update') }}",
                type: "POST",
                // dataType : "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    siswa_id,
                    kelas_id,
                    mata_pelajaran_id,
                    tahun_ajaran,
                    semester,
                    kategori_nilai,
                    nilai,
                    urutan_nilai: i
                }
            });
        }
        $("#btn_approve_" + siswa_id).addClass("disabled").attr("disabled", "disabled");
    }

    function add_cells(number) {
        var total_form = $("#total_form").val();
        var kelas_id = "<?php echo $_GET['kelas_id'] ?? ""; ?>";
        var mata_pelajaran_id = "<?php echo $_GET['mata_pelajaran_id'] ?? ""; ?>";
        var tahun_ajaran = "<?php echo $_GET['tahun_ajaran'] ?? ""; ?>";
        var semester = "<?php echo $_GET['semester'] ?? ""; ?>";
        var kategori_nilai = "<?php echo $_GET['kategori_nilai'] ?? ""; ?>";
        //Jika kosong
        if (kelas_id == "" || mata_pelajaran_id == "" || tahun_ajaran == "" || semester == "" || kategori_nilai == "") {
            swal({
                title: "Oops!",
                text: "Tidak dapat menambah nilai.",
                type: "warning",
                buttonsStyling: false,
                confirmButtonClass: "btn btn-warning"
            }).catch(swal.noop);
        }
        //Jika tidak
        else {
            //Pemanggilan dengan ajax dilakukan agar dapat memnpengaruhi semua baris karena isinya dan id nya berbeda-beda
            $.ajax({
                url: "{{ route('admin.daftar-nilai.store') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    kelas_id,
                    mata_pelajaran_id,
                    tahun_ajaran,
                    semester,
                    kategori_nilai,
                    urutan_nilai: number
                },
                success: function(data) {
                    var i;

                    //For thead Nilai
                    var nilai = "";
                    if (kategori_nilai == "UH") {
                        nilai = "UH";
                    } else if (kategori_nilai == "UTS") {
                        nilai = "UTS";
                    } else if (kategori_nilai == "UAS") {
                        nilai = "UAS";
                    } else if (kategori_nilai == "Tugas Harian") {
                        nilai = "TH";
                    } else if (kategori_nilai == "Praktek") {
                        nilai = "Prak";
                    }

                    var buttons = '<button type="button" class="btn btn-danger btn-sm btn-just-icon" style="border-radius:0;" onclick="remove_cells(' + number + ')"><i class="fa fa-times"></i></button></th>';

                    //Penambahan Cell
                    var cell = '<th id="cells_' + number + '" style="width:10%;">' + nilai + number;

                    if (number == 2) {
                        cell += " " + buttons;
                        $("#nr_cell").before(cell);
                    } else if (number > 2) {
                        var number_befored = number - 1;
                        // if(number_befored >= 1){
                        $("#cells_" + number_befored + " button").remove();
                        // }
                        cell += " " + buttons;
                        $("#nr_cell").before(cell);
                    }

                    var form = "";
                    //Melakukan perulangan agar semua baris terpengaruhi
                    for (i = 0; i < data.siswa.length; i++) {
                        form = '<td id="cells_' + data.siswa[i].id + '_' + number + '"><input type="number" class="form-control" name="nilai_' + number + '_' + data.siswa[i].id + '" id="nilai_' + number + '_' + data.siswa[i].id + '" onchange="nilai_changed(' + data.siswa[i].id + ')"></td>';
                        if (number >= 2) {
                            $("#nr_cells_" + data.siswa[i].id).before(form);
                        }
                    }

                    $("#total_form").val(number);
                },
                error: function(errorThrown, textStatus, jqXHR) {
                    swal({
                        title: "Failed!",
                        text: "Gagal melakukan penambahan nilai.",
                        type: "error",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-danger"
                    }).catch(swal.noop);
                }
            });
        }
    }

    function remove_cells(number) {
        //Konfirmasi bahwa data akan dihapus
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Nilai yang telah dimasukkan tidak dapat dikembalikan",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then(function() {
            //Prosess Penghapusan data
            var total_form = $("#total_form").val();
            var kelas_id = "<?php echo $_GET['kelas_id'] ?? ""; ?>";
            var mata_pelajaran_id = "<?php echo $_GET['mata_pelajaran_id'] ?? ""; ?>";
            var tahun_ajaran = "<?php echo $_GET['tahun_ajaran'] ?? ""; ?>";
            var semester = "<?php echo $_GET['semester'] ?? ""; ?>";
            var kategori_nilai = "<?php echo $_GET['kategori_nilai'] ?? ""; ?>";

            $.ajax({
                url: "{{ route('admin.daftar-nilai.destroy')}}",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: "DELETE",
                    kelas_id,
                    mata_pelajaran_id,
                    tahun_ajaran,
                    semester,
                    kategori_nilai,
                    urutan_nilai: number
                },
                success: function(data) {
                    var number_befored = number - 1;
                    var cell_before = $("#cells_" + number_befored).html();
                    var cell_after;

                    var buttons = '<button type="button" class="btn btn-danger btn-sm btn-just-icon" style="border-radius:0;" onclick="remove_cells(' + number_befored + ')"><i class="fa fa-times"></i></button></th>';
                    if (number > 2) {
                        cell_after = cell_before + ' ' + buttons;
                        $("#cells_" + number_befored).html(cell_after);
                    }
                    $("#cells_" + number).remove();

                    var second_number = number;

                    number--;
                    if (number < 1) {
                        number = 1;
                    }

                    //Melakukan perulangan agar semua baris terpengaruhi
                    var nilai, total_nilai = 0,
                        hasil_akhir_nilai;
                    var j;
                    for (i = 0; i < data.siswa.length; i++) {
                        for (j = 1; j <= number; j++) {
                            nilai = $("#nilai_" + j + "_" + data.siswa[i].id).val();
                            total_nilai += parseInt(nilai);
                        }

                        hasil_akhir_nilai = total_nilai / number;

                        if (hasil_akhir_nilai >= 0) {
                            $("#nilai_average_" + data.siswa[i].id).val(hasil_akhir_nilai);
                        } else {
                            $("#nilai_average_" + data.siswa[i].id).val("0");
                        }

                        $("#cells_" + data.siswa[i].id + "_" + second_number).remove();
                    }

                    console.log(data);

                    $("#total_form").val(number);
                },
                error: function(jqXHR, errorThrown, textStatus) {
                    swal({
                        title: "Failed!",
                        text: "Gagal melakukan pengurangan nilai.",
                        type: "error",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-danger"
                    }).catch(swal.noop);
                }
            });
        })
    }

    function nilai_changed(id_siswa) {
        var total = $("#total_form").val();

        //Membuat nilai rata-rata
        var total_nilai = 0;
        var nilai, nr;
        var i;
        for (i = 1; i <= total; i++) {
            nilai = $("#nilai_" + i + "_" + id_siswa).val();
            total_nilai += parseInt(nilai);
        }

        nr = total_nilai / total;
        if (nr >= 0) {
            $("#nilai_average_" + id_siswa).val(nr);
        } else {
            $("#nilai_average_" + id_siswa).val("0");
        }
        $("#btn_approve_" + id_siswa).removeClass("disabled").removeAttr("disabled");

    }

    $(document).ready(function() {



        var number = $("#total_form").val();
        $("#btnTambahNilai").click(function() {
            if ($("#total_form").val() != number) {
                number = $("#total_form").val();
            }
            number++;
            add_cells(number);
            // console.log(number);
        });
    });
</script>
@endpush
