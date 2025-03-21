@extends('layouts.app')
@section('title', 'Edit Branch') 
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
								Edit Branch
							</div>
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
							<form action="{{ route('branch.update', $branch) }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('PUT') 
								<div class="mb-13">
									<h1 class="mb-3">Edit Branch</h1>
									<div class="text-muted fw-semibold fs-5">
										Edit Branch {{$branch->branch_name}}
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
										value="{{$branch->branch_name}}"
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
										value="{{$branch->branch_address}}"
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
										value="{{$branch->branch_province}}"
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
										value="{{$branch->branch_city}}"
									/> 
								</div>

								<!-- Email Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Branch Star</span>
									</label> 
										<select class="form-select form-control form-control-solid" name="branch_star">
											<option value="1" @if($branch->branch_star == 1) selected @endif>1 ⭐</option>
											<option value="2" @if($branch->branch_star == 2) selected @endif>2 ⭐⭐</option>
											<option value="3" @if($branch->branch_star == 3) selected @endif>3 ⭐⭐⭐</option>
											<option value="4" @if($branch->branch_star == 4) selected @endif>4 ⭐⭐⭐⭐</option>
											<option value="5" @if($branch->branch_star == 5) selected @endif>5 ⭐⭐⭐⭐⭐</option>
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
										value="{{$branch->branch_phone}}"
									/> 
								</div>
			
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span>Branch Website</span> 
									</label>
									<input 
										type="text"  name="branch_web"
										class="form-control form-control-solid" 
										value="{{$branch->branch_web}}"
									/> 
								</div>

								<!-- Email Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Branch Google Maps Link</span>
									</label>
									<input 
										type="text" name="branch_maps_link" 
										class="form-control form-control-solid" 
										value="{{$branch->branch_maps_link}}"
									/> 
								</div> 
							
								<div class="fv-row mb-7">
									<label class="d-block fw-semibold fs-6 mb-5">Hotel Logo</label> 
									<!-- Image container -->
									<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
										<!-- Preview area -->
										<img id="logo-preview" 
										src="{{asset('storage/'.$branch->branch_logo)}}" 
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
									<label class="d-block fw-semibold fs-6 mb-5">Hotel Thumbnail</label> 
									<!-- Image container -->
									<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
										<!-- Preview area -->
										<img id="thumbnail-preview" 
										src="{{asset('storage/'.$branch->branch_thumbnail)}}" 
										class="img-fluid" 
										style="max-width: 500px; height: auto;"> 

										<!-- Change Button -->
										<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
										data-kt-image-input-action="change" 
										data-bs-toggle="tooltip" 
										title="Change thumbnail">
										<i class="ki-solid ki-pencil fs-7"></i>
										<input type="file" 
											name="branch_thumbnail" 
											accept="image/*"
											class="d-none"
											id="branch-thumbnail-input">
										<input type="hidden" name="thumbnail_remove">
										</label>
								
										<!-- Cancel Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="cancel" 
											  data-bs-toggle="tooltip" 
											  title="Cancel thumbnail">
											  <i class="ki-solid ki-cross"></i>
										</span>
								
										<!-- Remove Button -->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											  data-kt-image-input-action="remove" 
											  data-bs-toggle="tooltip" 
											  title="Remove thumbnail">
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

								@if(isset($branch) && $branch->photos->count() > 0)
								<div class="fv-row mb-5">
									<h5>Existing Photos</h5>
									<div class="row g-5">
										@foreach($branch->photos as $photo)
										<div class="col-md-3">
											<div class="card">
												<img src="{{ Storage::url($photo->path) }}" class="card-img-top" alt="Room photo">
												<div class="card-footer text-center">
													<input type="checkbox" name="deleted_photos[]" value="{{ $photo->id }}" 
														id="delete-photo-{{ $photo->id }}">
													<label class="form-label text-danger" for="delete-photo-{{ $photo->id }}">
														<i class="fas fa-trash"></i> Mark for deletion
													</label>
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
								@endif
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
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->

<script> 
    $(document).ready(function() {
    $('#table_user').DataTable({
        "paging":   true,
        "ordering": true,
    } );
} );
$(".delete").on('click', function(event){
    event.stopPropagation();
    event.stopImmediatePropagation(); 
    var href = $(this).attr('href');
           Swal.fire({
       title: 'Yakin untuk menghapus data ini ? ',
       text: 'Data ini akan dihapus dan tidak dapat dikembalikan!',
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#95000c',
       confirmButtonText: 'Ya, Hapus!',
       cancelButtonText: 'Tidak, batalkan'
     }).then((result) => {
       if (result.value) {
          window.location.href = href;

       //  For more information about handling dismissals please visit
       // https://sweetalert2.github.io/#handling-dismissals
       } else if (result.dismiss === Swal.DismissReason.cancel) {
         Swal.fire(
           'Dibatalkan',
           'Data tidak jadi dihapus',
           'error'
         )
       }
     });

});
</script> 


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