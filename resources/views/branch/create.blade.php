@extends('layouts.app')
@section('title', 'Create Branch') 
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
						   </div>
						   <!--begin::Card title-->
						   <!--begin::Card toolbar-->
						   <div class="card-toolbar">
							  <!--begin::Toolbar-->
							  <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"> 
								 <!--begin::Add user-->
								 <a class="btn btn-secondary" href="{{url('management/config/branch')}}">
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
							@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

							<form action="{{url('management/config/branch/store')}}" method="POST" enctype="multipart/form-data">
								@csrf 
								<div class="mb-13">
									<h1 class="mb-3">Create Branch</h1>
									<div class="text-muted fw-semibold fs-5">
										Create new Hotel Branch
									</div>
								</div>
								 
								<!-- Name Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Branch Name </span>
									</label>
									<input 
										type="text"  name="branch_name"
										class="form-control form-control-solid"  
									/> 
								</div>
			
								<!-- Email Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Branch Adress</span>
									</label>
									<input 
										type="text" name="branch_address" 
										class="form-control form-control-solid"  
									/> 
								</div>

									<!-- Email Input -->
									<div class="d-flex flex-column mb-8 fv-row">
										<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
											<span class="required">Branch Province</span>
										</label>
										<input 
											type="text" name="branch_province" 
											class="form-control form-control-solid"  
										/> 
									</div>
	
									<!-- Email Input -->
									<div class="d-flex flex-column mb-8 fv-row">
										<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
											<span class="required">Branch City</span>
										</label>
										<input 
											type="text" name="branch_city" 
											class="form-control form-control-solid"  
										/> 
									</div>
	
									<!-- Email Input -->
									<div class="d-flex flex-column mb-8 fv-row">
										<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
											<span class="required">Branch Star</span>
										</label> 
											<select class="form-select form-control form-control-solid" name="branch_star">
												<option value="1">1 ⭐</option>
												<option value="2">2 ⭐⭐</option>
												<option value="3">3 ⭐⭐⭐</option>
												<option value="4">4 ⭐⭐⭐⭐</option>
												<option value="5">5 ⭐⭐⭐⭐⭐</option>
											</select> 
									</div>
			
								<!-- Password Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span>Branch Phone</span> 
									</label>
									<input 
										type="text"  name="branch_phone"
										class="form-control form-control-solid"  
									/> 
								</div>
			
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span>Branch Website</span> 
									</label>
									<input 
										type="text"  name="branch_web"
										class="form-control form-control-solid"  
									/> 
								</div>
			  
								<div class="fv-row mb-7">
									<label class="d-block fw-semibold fs-6 mb-5 required" >Hotel Logo</label> 
									<!-- Image container -->
									<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
										<!-- Preview area -->
										<img id="logo-preview" 
										src="{{asset('assets/media/logos/logo-color.jpg')}}" 
										class="img-fluid" 
										style="max-width: 500px; height: auto;"> 

										<!-- Change Button -->
										<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
										data-kt-image-input-action="change" 
										data-bs-toggle="tooltip" 
										title="Change logo">
										<i class="ki-solid ki-pencil fs-7"></i>
										<input type="file" 
											name="branch_logo" 
											accept="image/*"
											class="d-none"
											id="branch-logo-input">
										<input type="hidden" name="logo_remove">
										</label>
								
										<!-- Cancel Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="cancel" 
											  data-bs-toggle="tooltip" 
											  title="Cancel logo">
											  <i class="ki-solid ki-cross"></i>
										</span>
								
										<!-- Remove Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="remove" 
											  data-bs-toggle="tooltip" 
											  title="Remove logo">
											  <i class="ki-solid ki-cross"></i>
										</span>
									</div>
									
									<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
								</div>

								<div class="fv-row mb-7">
									<label class="d-block fw-semibold fs-6 mb-5 required">Hotel Thumbnail</label> 
									<!-- Image container -->
									<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
										<!-- Preview area -->
										<img id="thumbnail-preview" 
										src="{{asset('assets/media/default-thumbnail.webp')}}" 
										class="img-fluid" 
										style="max-width: 500px; height: auto;"> 

										<!-- Change Button -->
										<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
										data-kt-image-input-action="change" 
										data-bs-toggle="tooltip" 
										title="Change thubmnail">
										<i class="ki-solid ki-pencil fs-7"></i>
										<input type="file" 
											name="branch_thumbnail" 
											accept="image/*"
											class="d-none"
											id="branch-thumbnail-input">
										<input type="hidden" name="thubmnail_remove">
										</label>
								
										<!-- Cancel Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="cancel" 
											  data-bs-toggle="tooltip" 
											  title="Cancel thubmnail">
											  <i class="ki-solid ki-cross"></i>
										</span>
								
										<!-- Remove Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="remove" 
											  data-bs-toggle="tooltip" 
											  title="Remove thubmnail">
											  <i class="ki-solid ki-cross"></i>
										</span>
									</div>
									
									<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
								</div>


								<div class="mb-5 fv-row">
									<label class="d-block fw-semibold fs-6 mb-5">Branch Photos</label>
									<input type="file" name="branch_photos[]" multiple 
										   class="form-control @error('branch_photos.*') is-invalid @enderror"
										   accept="image/*">
										@error('branch_photos.*')
										   <div class="invalid-feedback">{{ $message }}</div>
									   @enderror
									   @error('branch_photos')
										   <div class="invalid-feedback">{{ $message }}</div>
									   @enderror
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
@section('scripts') 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   document.getElementById('branch-logo-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo-preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
 
document.getElementById('branch-thumbnail-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('thumbnail-preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
 
    </script>
@endsection