@extends('layouts.app')
@section('title', 'Create Room Policy')   
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
                            <h3 class="card-title">Create New Room Policy</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('room-policies.store') }}" method="POST">
                                @csrf
                                @include('room-policies.partials.form')
                                
                                <div class="text-end mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Policy
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

  