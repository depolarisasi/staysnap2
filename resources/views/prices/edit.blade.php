@extends('layouts.app')
@section('title', 'Edit Amenity')   
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
                            <h3 class="card-title">Edit Amenity - {{ $amenity->name }}</h3>
                            <div class="card-toolbar">
                                <a href="{{ url('management/rooms/dynamic-pricing') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <form action="{{ route('amenities.update', $amenity) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('amenities.partials.form')
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Amenity
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