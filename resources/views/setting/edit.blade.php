@extends('layouts.app')
@section('title', 'Edit Config') 
@section('content') 
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Post-->
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<!--begin::Container-->
		<div id="kt_content_container" class="container-xxl">
			<!--begin::Row-->
			<div class="row g-5 g-xl-8">
				<div class="col-12"> 
					<div class="card">
						<!--begin::Card header-->
						<div class="card-header border-0 pt-6">
						   <!--begin::Card title-->
						   <div class="card-title"> 
							<div class="fw-semibold fs-5">
								Edit Config
							</div>
						   </div>
						   <!--begin::Card title-->
						   <!--begin::Card toolbar-->
						   <div class="card-toolbar">
							  <!--begin::Toolbar-->
							  <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"> 
								 <!--begin::Add user-->
								 <a class="btn btn-secondary" href="{{url('management/config')}}">
								 <i class="ki-solid ki-left fs-2"></i>Kembali</a>
								 <!--end::Add user-->
							  </div>
							  <!--end::Toolbar-->    
						   </div>
						   <!--end::Card toolbar-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body py-4">
							<form action="{{ route('setting.update', $setting) }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('PUT') 
								 
								<div class="mb-13">
									<h1 class="mb-3">Edit Configuration</h1>
									<div class="text-muted fw-semibold fs-5">
										Add {{$setting->key}}
									</div>
								</div>
								 
								<!-- Name Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Config Name</span>
									</label>
									<input 
										type="text"  name="key"
										class="form-control form-control-solid"  
										value="{{$setting->key}}"
									/> 
								</div>
			
								<!-- Email Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Config Value</span>
									</label>
									<input 
										type="text" name="value" 
										class="form-control form-control-solid"
										value="{{$setting->value}}"  
									/> 
								</div> 
 
								<div class="text-center"> 
									<button type="submit" class="btn btn-primary">
										<span class="indicator-label">Submit</span> 
									</button>
								</div>
							</form>
						</div>
						<!--end::Card body-->
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
 