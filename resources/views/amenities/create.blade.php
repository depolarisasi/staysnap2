@extends('layouts.app')
@section('title', 'Create Amenity')   
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
                            <h3 class="card-title">Create New Amenity</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('amenities.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('amenities.partials.form', [
                                    'imageFieldName' => $imageFieldName
                                ])
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Amenity
                                    </button>
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
    @include('amenities.partials.scripts')
@endsection