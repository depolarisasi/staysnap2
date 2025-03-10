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
								Edit Branch {{$branch->branch_name}}
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
							<form action="{{url('management/config/branches/update')}}" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="branch_id" value="{{$branch->id}}">
								<div class="mb-13 text-center">
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
			  
								<div class="fv-row mb-7">
									<label class="d-block fw-semibold fs-6 mb-5">Hotel Logo</label> 
									<!-- Image container -->
									<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
										<!-- Preview area -->
										<div class="image-input-wrapper img-fluid" 
											 style="background-image: url({{asset('storage/'.$branch->branch_logo)}})">
										</div>
								
										<!-- Change Button -->
										<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
											   data-kt-image-input-action="change" 
											   data-bs-toggle="tooltip" 
											   title="Change logo">
											<i class="ki-solid ki-pencil fs-7"></i>
											<input type="file" 
												   name="branch_logo" 
												   accept=".png, .jpg, .jpeg" 
												   class="d-none">
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
	$(document).ready(function() {
		const $previewDiv = $('.image-input-wrapper');
		const defaultImage = 'url(assets/media/logos/logo-color.svg)';
		
		// Handle file selection
		$('input[name="branch_logo"]').on('change', function(e) {
			const file = this.files[0];
			
			if (!file.type.match('image/(png|jpeg|jpg)')) {
				alert('Hanya file gambar yang diizinkan!');
				$(this).val('');
				return;
			}
			
			const reader = new FileReader();
			reader.onload = function(e) {
				$previewDiv.css('background-image', `url(${e.target.result})`);
			}
			reader.readAsDataURL(file);
		});
	
		// Handle cancel button
		$('[data-kt-image-input-action="cancel"]').on('click', function() {
			setTimeout(() => {
				$previewDiv.css('background-image', defaultImage);
			}, 10);
		});
	
		// Handle remove button
		$('[data-kt-image-input-action="remove"]').on('click', function() {
			$previewDiv.css('background-image', defaultImage);
			$('input[name="branch_logo"]').val('');
		});
	});
	</script>
@endsection