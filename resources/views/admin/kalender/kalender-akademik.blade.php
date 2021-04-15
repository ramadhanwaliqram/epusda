@extends('layouts.admin')

{{-- config 1 --}}
@section('title', 'Kalender | Kalender Akademik')
@section('title-2', 'Kalender Akademik')
@section('title-3', 'Kalender Akademik')

@section('describ')
Ini adalah halaman kalender akademik untuk admin
@endsection

@section('icon-l', 'fa fa-calendar')
@section('icon-r', 'icon-home')

@section('link')
{{ route('admin.kalender.kalender-akademik') }}
@endsection

{{-- main content --}}
@section('content')


@include('admin.kalender.modals._modal')

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12">
                            <div id="calendar">

                            </div>
                        </div>
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
@endsection



{{-- addons css --}}
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-clockpicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/sweetalert/css/sweetalert.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/datedropper/css/datedropper.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/fullcalendar/css/fullcalendar.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/fullcalendar/css/fullcalendar.print.css') }}" media='print'>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages.css') }}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> --}}
<style>
    .btn i {
        margin-right: 0px;
    }
</style>
@endpush

{{-- addons js --}}
@push('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
<script type="text/javascript" src="{{ asset('bower_components/moment/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/sweetalert/js/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/fullcalendar/js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
{{-- <script src="https://sekolah.schlrr.com/assets/js/js/fullcalendar.min.js"></script> --}}
{{-- <script src="{{ asset('assets/js/vertical/vertical-layout.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('bower_components/datedropper/js/datedropper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
{{-- <script src="{{ asset('bower_components/datedropper/js/datedropper.min.js') }}"></script> --}}


<script type="text/javascript">
    $(document).ready(function() {

        $('.clockpicker').clockpicker({
            donetext: 'Done',
            autoclose: true
        });

        $('#start_date').dateDropper({
            theme: 'leaf',
            format: 'd-m-Y'
        });

        $('#end_date').dateDropper({
            theme: 'leaf',
            format: 'd-m-Y'
        });

        // $('#external-events .fc-event').each(function() {

        //     // store data so the calendar knows to render an event upon drop
        //     $(this).data('event', {
        //         title: $.trim($(this).text()), // use the element's text as the event title
        //         stick: true // maintain when user navigates (see docs on the renderEvent method)
        //     });

        //     // make the event draggable using jQuery UI
        //     $(this).draggable({
        //         zIndex: 999,
        //         revert: true, // will cause the event to go back to its
        //         revertDuration: 0 //  original position after the drag
        //     });

        // });



        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            droppable: false,
            selectable: true,
            // displayEventTime: true,
            eventSources: [

                // your event source
                {
                    events: JSON.parse('{!!$events!!}'),
                    // an option!
                    textColor: 'white', // an option!
                    timeFormat: 'H(:mm)'
                }

                // any other event sources...

            ],
            select: function(start, end, allDay) {
                $("#addEvent").modal("show");
                $("#addEvent .modal-title").text("Tambah Event");
                $("#addEvent #title").val("");
                $("#addEvent form").attr("action", "tambah");
                $("#addEvent form").removeAttr("data-id");
                $("#addEvent #btnEvent").text("Simpan");
                $("#start_date").val(moment(start).format());
                $("#end_date").val(moment(end).format());
                $("#addEvent #start_clock").val("");
                $("#addEvent #end_clock").val("");
                $("#deleteEvent").html("");


            },

            eventClick: function(event) {
                $("#addEvent").modal("show");
                $("#addEvent .modal-title").text("Edit Event");
                $("#addEvent form").attr("action", "update");
                $("#addEvent #btnEvent").text("Update");
                $("#addEvent #title").val(event.title);
                $("#addEvent #start_date").val($.fullCalendar.formatDate(event.start, 'YYYY-MM-DD'));
                $("#addEvent #end_date").val($.fullCalendar.formatDate(event.end, 'YYYY-MM-DD'));
                $("#addEvent #start_clock").val(event.start.format("hh:mm"));
                $("#addEvent #end_clock").val(event.end.format("hh:mm"));

                var id_event = '<input type="hidden" id="id_event" name="id_event" value="' + event.id + '">';
                $("#input_hidden").html(id_event);

                var button_delete = '<button type="button" class="btn btn-sm btn-outline-danger" onclick=del_event(' + event.id + ')>Hapus Event</button>';
                $("#deleteEvent").html(button_delete);
                // var class_name;
                // if (event.className == "event-red") {
                //  class_name = 'Sangat Penting';
                // } else if (event.className == "event-orange") {
                //  class_name = 'Penting';
                // } else if (event.className == "event-azure") {
                //  class_name = 'Wajib Datang';
                // } else if (event.className == "event-rose") {
                //  class_name = 'Tidak Diwajibkan Datang';
                // } else if (event.className == "event-green") {
                //  class_name = 'Diharapkan Datang';
                // }

                // $("#prioritas option[value='" + class_name + "']").prop("selected", true);
            }

        });
        // $('#calendar').fullCalendar();



        //Fungsi Add-Update-Delete Data
        $("#addFormEvent").submit(function(e) {
            e.preventDefault();
            //
            var atribut = $(this).attr("action");
            var form_data = new FormData($(this)[0]);
            if (atribut == "tambah") {
                add_event(form_data);
            } else if (atribut == "update") {
                update_event(form_data);
            }
        });
    });


    function add_event(form_data) {
        //Pengumpulan Data
        console.log(form_data);
        var event_title = $("#event_title").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var start_clock = $("#start_clock").val();
        var end_clock = $("#end_clock").val();
        var prioritas = $("#prioritas").val();
        var class_name;
        if (prioritas == "Sangat Penting") {
            class_name = 'event-red';
        } else if (prioritas == "Penting") {
            class_name = 'event-orange';
        } else if (prioritas == "Wajib Datang") {
            class_name = 'event-azure';
        } else if (prioritas == "Tidak Diwajibkan Datang") {
            class_name = 'event-blue';
        } else if (prioritas == "Diharapkan Datang") {
            class_name = 'event-green';
        }

        //Jika kosong
        if (event_title == "" || start_date == "" || end_date == "" || start_clock == "" || end_clock == "" || prioritas == "") {
            swal({
                title: "Something is missing!",
                text: "Tolong Lengkapi Data",
                type: "warning",
                buttonsStyling: false,
                confirmButtonClass: "btn btn-warning"
            }).catch(swal.noop);
        }
        //Jika tidak
        else {
            //Memulai memasukan data ke database
            $.ajax({

                url: "{{route('admin.kalender.tambah-event')}}",
                method: "POST",
                dataType: "JSON",
                data: form_data,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        toastr.success('Sukses!');
                        location.reload();
                        $("#addEvent").modal("hide");
                        $("#title").val('');
                        $("#addEvent .modal-title").text("Tambah Event");
                        $("#addEvent form").attr("action", "tambah");
                        $("#addEvent form").removeAttr("data-id");
                        $("#addEvent #btnEvent").text("Simpan");
                        $("#start_date").val(moment(start).format());
                        $("#end_date").val(moment(end).format());
                        $("#addEvent #start_clock").val("");
                        $("#addEvent #end_clock").val("");
                        $("#deleteEvent").html("");

                    }

                },
            });

        }
    }

    function update_event(form_data) {

        $.ajax({
            url: "/admin/kalender/update/" + $("#id_event").val(),
            method: "POST",
            dataType: "JSON",
            data: form_data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#addEvent #btnEvent').text('Mengupdate...');
            },
            success: function(data) {

                setTimeout(function() {
                    $('#addEvent').modal('hide');

                    toastr.success('Data berhasil diubah');
                    location.reload();
                }, 1000);
            }
        });

    }

    function del_event(id_event) {
        //Konfirmasi bahwa data akan dihapus
        $('#ok_button').text('Hapus');
        $('#confirmModal').modal('show');
        //Prosess Penghapusan data
        $('#ok_button').click(function() {
            $.ajax({
                url: '/admin/kalender/hapus/' + id_event,
                beforeSend: function() {
                    $('#ok_button').text('Menghapus...');
                },
                success: function(data) {
                    if (data.success) {
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                            $('#addEvent').modal('hide');
                            // $('#order-table').DataTable().ajax.reload();
                            toastr.success('Data berhasil dihapus');
                            location.reload();
                        }, 1000);
                    }

                }
            });
        });
    }
</script>
@endpush
