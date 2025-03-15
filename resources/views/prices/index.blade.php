@extends('layouts.app')
@section('title', 'Room Price')  
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
                                        <small class="text-muted">Harga dasar: Rp {{ number_format($room->base_price) }}</small>
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
    const room = @json($room); 
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('priceCalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            selectable: true,
            selectMirror: true,
            selectMinDistance: 5, // Beda antara click dan drag
            events: "{{ route('prices.events', $room) }}",
            // Handle bulk select (drag or multi-date)
            select: function(info) {
                const endDate = info.endStr.split('T')[0];
                const isSingleDay = info.startStr === endDate;
                const end = isSingleDay ? 
                    info.startStr : 
                    new Date(info.end.getTime() - 86400000).toISOString().split('T')[0];
                
                $('#bulkUpdateModal input[name="start_date"]').val(info.startStr);
                $('#bulkUpdateModal input[name="end_date"]').val(end);
                
                // Cek apakah ada harga di range ini
                $.ajax({
                    url: "{{ route('prices.check-existing', $room) }}",
                    data: {
                        start_date: info.startStr,
                        end_date: end
                    },
                    success: function(response) {
                        $('#bulkDeleteBtn').toggle(response.exists); // Tampil jika ada
                    },
                    error: function() {
                        $('#bulkDeleteBtn').hide();
                    }
                });
                
                $('#bulkUpdateModal').modal('show');
                calendar.unselect();
            },
            // Handle klik tanggal (single date)
            dateClick: function(info) {
                $('#bulkUpdateModal input[name="start_date"]').val(info.dateStr);
                $('#bulkUpdateModal input[name="end_date"]').val(info.dateStr);

                // Cek apakah ada harga di tanggal ini
                $.ajax({
                    url: "{{ route('prices.check-existing', $room) }}",
                    data: {
                        start_date: info.dateStr,
                        end_date: info.dateStr
                    },
                    success: function(response) {
                        $('#bulkDeleteBtn').toggle(response.exists);
                    }
                });
                
                $('#bulkUpdateModal').modal('show');
            },
            // Handle klik event harga existing
            eventClick: function(info) {
                const price = parseFloat(info.event.title.replace(/[^0-9]/g, ''));
                Swal.fire({
                    title: 'Kelola Harga',
                    html: `
                        <p>Tanggal: ${info.event.startStr}</p>
                        <input id="swalPrice" type="number" class="form-control mt-3" 
                           value="${price}" min="${room.base_price}">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update Harga',
                    cancelButtonText: 'Hapus Harga',
                    reverseButtons: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            price: document.getElementById('swalPrice').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update harga
                        $.ajax({
                            url: "{{ route('prices.update-single', $room) }}",
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                date: info.event.startStr,
                                price: result.value.price
                            },
                            success: () => {
                                info.event.setProp('title', 'Rp ' + result.value.price);
                                toastr.success('Harga diperbarui');
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Hapus harga
                        $.ajax({
                            url: "{{ route('prices.delete-single', $room) }}",
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: { date: info.event.startStr },
                            success: () => {
                                info.event.remove();
                                toastr.success('Harga dihapus');
                            }
                        });
                    }
                });
            },
            eventDidMount: function(info) {
                if(info.event.extendedProps.type === 'custom_price') {
                    info.event.setProp('title', '★ ' + info.event.title);
                }
            }
        });
    
        calendar.render();
    
        // Handle bulk update
        $('#bulkUpdateForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('prices.bulk-update', $room) }}",
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: $(this).serialize(),
                success: function() {
                    calendar.refetchEvents();
                    $('#bulkUpdateModal').modal('hide');
                    toastr.success('Harga berhasil diperbarui');
                }
            });
        });
    
        // Handle bulk delete
        $('#bulkDeleteBtn').click(function() {
            const start = $('input[name="start_date"]').val();
            const end = $('input[name="end_date"]').val();
            
            Swal.fire({
                title: 'Hapus Harga?',
                text: `Hapus harga dari ${start} hingga ${end}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('prices.bulk-delete', $room) }}",
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: { start_date: start, end_date: end },
                        success: () => {
                            calendar.refetchEvents();
                            $('#bulkUpdateModal').modal('hide');
                            toastr.success('Harga dihapus');
                        }
                    });
                }
            });
        });
    });
    </script>
    
@endsection