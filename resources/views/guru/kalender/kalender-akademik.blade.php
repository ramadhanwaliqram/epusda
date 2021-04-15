@extends('layouts.guru')

{{-- config 1 --}}
@section('title', 'Kalender | Kalender Akademik')
@section('title-2', 'Kalender Akademik')
@section('title-3', 'Kalender Akademik')

@section('describ')
    Ini adalah halaman kalender akademik untuk guru
@endsection

@section('icon-l', 'fa fa-calendar')
@section('icon-r', 'icon-home')

@section('link')
    {{ route('guru.kalender.kalender-akademik') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- addons css --}}
@push('css')
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
    <script type="text/javascript" src="{{ asset('bower_components/fullcalendar/js/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/full-calender/calendar.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    {{-- <script src="https://sekolah.schlrr.com/assets/js/js/fullcalendar.min.js"></script> --}}
    {{-- <script src="{{ asset('assets/js/vertical/vertical-layout.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
@endpush

<script>
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        // events: SITEURL + "/fullcalender",
        displayEventTime: false,
        editable: true,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                    event.allDay = true;
            } else {
                    event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                $.ajax({
                    // url: SITEURL + "/fullcalenderAjax",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        type: 'add'
                    },
                    type: "POST",
                    success: function (data) {
                        displayMessage("Event Created Successfully");

                        calendar.fullCalendar('renderEvent',
                            {
                                id: data.id,
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },true);

                        calendar.fullCalendar('unselect');
                    }
                });
            }
        },
        eventDrop: function (event, delta) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

            $.ajax({
                // url: SITEURL + '/fullcalenderAjax',
                data: {
                    title: event.title,
                    start: start,
                    end: end,
                    id: event.id,
                    type: 'update'
                },
                type: "POST",
                success: function (response) {
                    displayMessage("Event Updated Successfully");
                }
            });
        },
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    // url: SITEURL + '/fullcalenderAjax',
                    data: {
                            id: event.id,
                            type: 'delete'
                    },
                    success: function (response) {
                        calendar.fullCalendar('removeEvents', event.id);
                        displayMessage("Event Deleted Successfully");
                    }
                });
            }
        }

    });
    // $('#calendar').fullCalendar();

function displayMessage(message) {
    toastr.success(message, 'Event');
}
</script>
