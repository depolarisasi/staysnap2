@extends('layouts.app')
@section('title', 'Amenities')  
@section('styles') 
<style>
    .fc-event {
        cursor: pointer;
    }
    #priceCalendar {
        max-width: 1000px;
        margin: 20px auto;
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
                            <h3 class="card-title">Dynamic Pricing - {{ $room->name }}</h3>
                        </div>
                        <div class="card-body">
                            <div id="priceCalendar"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Bulk Update Modal -->
                <div class="modal fade" id="bulkUpdateModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="bulkUpdateForm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Harga</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Selesai</label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Harga Per Malam</label>
                                        <input type="number" name="price" class="form-control" 
                                               min="{{ $room->base_price }}" 
                                               value="{{ $room->base_price }}" required>
                                        <small class="text-muted">Harga dasar: IDR {{ number_format($room->base_price) }}</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger" id="bulkDeleteBtn">Hapus Harga</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
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
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('priceCalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            selectable: true, // [!] Enable date selection
            selectMirror: true,
            events: "{{ route('prices.events', $room) }}",
            select: function(info) {
                $('#bulkUpdateModal').modal('show');
                $('input[name="start_date"]').val(info.startStr);
                $('input[name="end_date"]').val(info.endStr);
                calendar.unselect(); // Reset selection
            },
            eventDidMount: function(info) {
                if(info.event.extendedProps.type === 'custom_price') {
                    info.event.setProp('title', '★ ' + info.event.title);
                }
            }
        });

        calendar.render();

        // Handle bulk update form
        $('#bulkUpdateForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('prices.bulk-update', $room) }}",
                method: 'POST',
                headers: { // [+] Tambahkan header CSRF
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: $(this).serialize(),
                success: function() {
                    calendar.refetchEvents();
                    $('#bulkUpdateModal').modal('hide');
                    toastr.success('Harga berhasil diperbarui');
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });
        calendar.setOption('eventClick', function(info) {
            const roomId = info.event.extendedProps.room_id;
            const priceId = info.event.id;

            const priceDate = info.event.startStr;
            const priceValue = info.event.title.replace(/[^0-9]/g, '');
            
            Swal.fire({
                title: 'Kelola Harga',
                html: `<p>Tanggal: ${priceDate}</p>
                    <p>Harga Saat Ini: ${info.event.title}</p>`,
                showCancelButton: true,
                confirmButtonText: 'Hapus Harga',
                cancelButtonText: 'Tutup',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('management/rooms') }}/" + roomId + "/prices/" + priceId,
                        method: 'DELETE',
                        data: { 
                            'priceId': priceId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            info.event.remove();
                            toastr.success('Harga berhasil dihapus');
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message); 
                        }
                    });
                }
            });
        });

        $('#bulkDeleteBtn').click(function() {
        const startDate = $('input[name="start_date"]').val();
        const endDate = $('input[name="end_date"]').val();
        
        Swal.fire({
            title: 'Hapus Harga',
            html: `Hapus semua harga dari <b>${startDate}</b> hingga <b>${endDate}</b>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('prices.bulk-delete', $room) }}",
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function() {
                        calendar.refetchEvents();
                        $('#bulkUpdateModal').modal('hide');
                        toastr.success('Harga berhasil dihapus');
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error');
                    }
                });
            }
        });
    });
 
    });
      
</script>
@endsection