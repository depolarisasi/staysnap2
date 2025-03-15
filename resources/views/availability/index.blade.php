@extends('layouts.app')
@section('title', 'Room Availability')  

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.css" rel="stylesheet">
<style>
    .fc-event {
        cursor: pointer;
        font-size: 0.9em;
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
</style>
@endsection
@section('content') 
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Post-->
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<!--begin::Container-->
		<div id="kt_content_container" class="container-xxl">
			<!--begin::Row-->
			<div class="row g-5 g-xl-8">  
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Room Availability - {{ $room->name }}</h3>
                            <div class="card-toolbar">
                                <a href="{{ url('management/rooms/') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="color-legend">
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #48bb78"></div>
                                    <span>Tersedia ≥75%</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #ecc94b"></div>
                                    <span>Tersedia 25-74%</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #f56565"></div>
                                    <span>Tersedia <25%</span>
                                </div>
                            </div>
                            
                            <div id="availabilityCalendar"></div>
                        </div>
                    </div>
                </div>
 
                <div class="modal fade" id="availabilityModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="availabilityForm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Availability</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Available Rooms</label>
                                        <input type="number" name="available" class="form-control" 
                                            min="0" max="{{ $room->stock }}" 
                                            value="{{ $room->stock }}" required>
                                        <small class="text-muted">Stock: {{ $room->stock }} rooms</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
			<!--end::Row--> 
		    </div>
		<!--end::Container-->
	</div>
	<!--end::Post-->
</div>
<!--end::Content-->
 
@endsection 


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/main.min.js"></script>
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
            events: "{{ route('availability.events', $room) }}",
            dateClick: function(info) {
                $('#availabilityModal').modal('show');
                $('input[name="start_date"]').val(info.dateStr);
                $('input[name="end_date"]').val(info.dateStr);
            },
            eventDidMount: function(info) {
                info.el.setAttribute('title', info.event.title);
            }
        });
        calendar.render();

        // Handle form submission
        $('#availabilityForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('availability.bulk-update', $room) }}",
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: $(this).serialize(),
                success: function() {
                    calendar.refetchEvents();
                    $('#availabilityModal').modal('hide');
                    toastr.success('Availability updated successfully');
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection

 