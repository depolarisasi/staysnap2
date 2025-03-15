@extends('layouts.app')
@section('title', 'Room Price')  
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
    <style>
        .table-container {
            overflow-x: auto;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 16px;
            font-size: 12px;
            text-align: center;
        }
        .editable-cell {
            cursor: pointer;
            font-weight: bold;
            background: #f8f9fa;
            border-radius: 6px;
            padding: 10px;
        }
        th {
            background: #007bff;
            color: white;
            font-size: 12px;
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
			 
            <h3 class="mb-3">Manajemen Harga Kamar</h3>

    <!-- Navigasi Mingguan -->
    <div class="d-flex justify-content-between mb-3">
        <button id="prevWeek" class="btn btn-sm btn-secondary">Minggu Sebelumnya</button>
        <h5 id="weekRange" class="text-center"></h5>
        <button id="nextWeek" class="btn btn-sm btn-secondary">Minggu Berikutnya</button>
    </div>

    <!-- Tabel Harga Kamar -->
    <div class="table-container">
        <table id="pricesTable" class="display nowrap table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Room</th>
                    <th id="date-1"></th>
                    <th id="date-2"></th>
                    <th id="date-3"></th>
                    <th id="date-4"></th>
                    <th id="date-5"></th>
                    <th id="date-6"></th>
                    <th id="date-7"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

		<!--end::Container-->
	</div>
	<!--end::Post-->
</div>
<!--end::Content-->
 
@endsection 


@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script src="https://momentjs.com/downloads/moment.min.js"></script>

<script>
    $(document).ready(function() {
        let startDate = moment().startOf('week').add(1, 'days'); // Mulai dari Senin
        let table = $('#pricesTable').DataTable({
            scrollX: true,
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            columns: [
                { data: 'room', title: 'Room' },
                { data: 'date_1', title: '' },
                { data: 'date_2', title: '' },
                { data: 'date_3', title: '' },
                { data: 'date_4', title: '' },
                { data: 'date_5', title: '' },
                { data: 'date_6', title: '' },
                { data: 'date_7', title: '' }
            ]
        });

        function loadPrices() {
            let formattedStart = startDate.format('YYYY-MM-DD');
            $('#weekRange').text(startDate.format('DD MMM YYYY') + ' - ' + startDate.clone().add(6, 'days').format('DD MMM YYYY'));

            // Atur header tanggal dengan format "Senin, 8 Mar 2025"
            for (let i = 1; i <= 7; i++) {
                let date = startDate.clone().add(i - 1, 'days');
                $(`#date-${i}`).text(date.format('dddd, D MMM YYYY'));
            }

            $.ajax({
                url: "{{ route('prices.weekly') }}",
                method: "GET",
                data: { start_date: formattedStart },
                success: function(response) {
                    let data = [];
                    let groupedByRoom = {};
                    response.prices.forEach(price => {
                        if (!groupedByRoom[price.room_id]) {
                            groupedByRoom[price.room_id] = { room: price.room_name };
                        }
                        groupedByRoom[price.room_id]['date_' + (moment(price.date).diff(startDate, 'days') + 1)] =
                            `<span class="editable-cell" data-room="${price.room_id}" data-date="${price.date}" data-price="${price.price}">
                                Rp ${parseInt(price.price).toLocaleString('id-ID')}
                            </span>`;
                    });

                    for (let key in groupedByRoom) {
                        data.push(groupedByRoom[key]);
                    }

                    table.clear().rows.add(data).draw();
                }
            });
        }

        // Navigasi Mingguan
        $('#prevWeek').click(() => { startDate.subtract(7, 'days'); loadPrices(); });
        $('#nextWeek').click(() => { startDate.add(7, 'days'); loadPrices(); });

        // Modal Edit Harga
        $(document).on('click', '.editable-cell', function() {
            let roomId = $(this).data('room');
            let date = $(this).data('date');
            let oldPrice = $(this).data('price');

            Swal.fire({
                title: 'Edit Harga',
                input: 'number',
                inputLabel: `Harga untuk ${moment(date).format('dddd, D MMM YYYY')}`,
                inputValue: oldPrice,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    $.ajax({
                        url: `/management/rooms/${roomId}/prices/update-single`,
                        method: 'PUT',
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        data: { date: date, price: result.value },
                        success: function() {
                            Swal.fire('Berhasil!', 'Harga telah diperbarui.', 'success');
                            loadPrices();
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Tidak bisa menyimpan harga.', 'error');
                        }
                    });
                }
            });
        });

        loadPrices();
    });
</script>
@endsection