@extends('layouts.app')
@section('title', 'Edit Slider') 
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
							<form action="{{ route('slider.update', $slider) }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('PUT') 
								 
								<div class="mb-13">
									<h1 class="mb-3">Edit Slider</h1>
									<div class="text-muted fw-semibold fs-5">
										Edit {{$slider->key}}
									</div>
								</div>
								 
								<!-- Name Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Slider Name</span>
									</label>
									<input 
										type="text"  name="title"
										class="form-control form-control-solid"  
										value="{{$slider->title}}"
									/> 
								</div>
			
								
								<div class="fv-row mb-7">
									<label class="d-block fw-semibold fs-6 mb-5 required" >Slider Image</label> 
									<!-- Image container -->
									<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
										<!-- Preview area -->
										<img id="image-preview" 
										src="{{asset('storage/'.$slider->image)}}" 
										class="img-fluid" 
										style="max-width: 500px; height: auto;"> 

										<!-- Change Button -->
										<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
										data-kt-image-input-action="change" 
										data-bs-toggle="tooltip" 
										title="Change image">
										<i class="ki-solid ki-pencil fs-7"></i>
										<input type="file" 
											name="image" 
											accept="image/*"
											class="d-none"
											id="branch-image-input">
										<input type="hidden" name="image_remove">
										</label>
								
										<!-- Cancel Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="cancel" 
											  data-bs-toggle="tooltip" 
											  title="Cancel image">
											  <i class="ki-solid ki-cross"></i>
										</span>
								
										<!-- Remove Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="remove" 
											  data-bs-toggle="tooltip" 
											  title="Remove image">
											  <i class="ki-solid ki-cross"></i>
										</span>
									</div>
									
									<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
								</div>
  
									<button type="submit" class="btn btn-primary">
										<span class="indicator-label">Submit</span> 
									</button> 
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
 