@extends('layouts.app')
@section('title', 'All Rooms Availability')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.css" rel="stylesheet">
<style>
    .fc-event {
        cursor: pointer;
        font-size: 0.8em;
        padding: 2px 5px;
    }
    #availabilityCalendar {
        max-width: 1000px;
        margin: 20px auto;
    }
    .color-legend {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 3px;
    }
    .room-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    .room-card {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row g-5 g-xl-8">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Rooms Availability</h3>
                        </div>
                        <div class="card-body">
                            <div class="color-legend">
                                <!-- Tambahkan legend yang sama seperti sebelumnya -->
                            </div>
                            
                            <div class="room-list">
                                @foreach($rooms as $room)
                                <div class="room-card">
                                    <h5>{{ $room->name }}</h5>
                                    <p>Total Stock: {{ $room->stock }}</p>
                                    <a href="{{ route('availability.index', $room) }}" class="btn btn-sm btn-primary">
                                        View Details
                                    </a>
                                </div>
                                @endforeach
                            </div>

                            <div id="availabilityCalendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('availabilityCalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            events: "{{ route('availability.all-events') }}",
            eventDidMount: function(info) {
                info.el.setAttribute('title', info.event.title);
            },
            eventClick: function(info) {
                const roomId = info.event.extendedProps.room_id;
                window.location.href = `${roomId}/availability`;
            }
        });
        calendar.render();
    });
</script>
@endsection