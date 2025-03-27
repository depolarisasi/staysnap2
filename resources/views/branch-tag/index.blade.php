@extends('layouts.app')
@section('title', 'Branch Tag')   
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
                            <h3 class="card-title">Branch Tag</h3>
                            <div class="card-toolbar">
                                <a href="{{ route('tags.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-row-bordered gy-5 gs-7" id="amenities-table">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 bg-light-dark">
                                        <th>Name</th> 
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                            </table>
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
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> 
<script>
    $(document).ready(function() {
        $('#amenities-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tags.datatable') }}",
            columns: [
                { data: 'name', name: 'name' },
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
                searchPlaceholder: 'Search facilities...'
            }
        });
    });
</script>
@endsection