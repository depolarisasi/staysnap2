<script>
    $(document).ready(function() {
        const table = $('#room-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('rooms.datatable') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.search = d.search.value;
                }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'branch.branch_name', name: 'branch.branch_name' },
                { 
                    data: 'base_price', 
                    name: 'base_price',
                    render: function(data) {
                        const number = parseFloat(data) || 0; // Fallback ke 0 jika invalid
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
                    }
                },
                { data: 'capacity', name: 'capacity' },
                { data: 'stock', name: 'stock' },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        const statusClasses = {
                            operational: 'badge-light-success',
                            maintenance: 'badge-light-warning',
                            closed: 'badge-light-danger'
                        };
                        
                        return `<span class="badge ${statusClasses[data]} fs-7 fw-bold py-2 px-3">
                                    ${data.charAt(0).toUpperCase() + data.slice(1)}
                                </span>`;
                    }
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'text-end'
                }
            ],
            order: [[0, 'asc']],
            dom: 
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-content-start'f>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'l>" +
                ">" +
                "<'table-responsive'tr>" +
                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">",
            language: {
                search: '',
                searchPlaceholder: 'Search rooms...',
                lengthMenu: 'Show _MENU_ entries',
                emptyTable: 'No rooms found',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries'
            }
        });

        // Delete handler
        $('#room-table').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            confirmDelete().then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    function confirmDelete() {
        return Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        });
    }
</script>