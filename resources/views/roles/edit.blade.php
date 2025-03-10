@extends('layouts.app')
@section('title', 'Edit Role') 
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
								Edit Role {{$role->name}}
							</div>
						   </div>
						   <!--begin::Card title-->
						   <!--begin::Card toolbar-->
						   <div class="card-toolbar">
							  <!--begin::Toolbar-->
							  <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"> 
								 <!--begin::Add user-->
								 <a class="btn btn-secondary" href="{{url('management/role')}}">
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
							<form method="POST" action="{{ route('roles.update', $role) }}">
								@csrf
								@method('PUT')
								 
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Role Name </span>
									</label>
									<input 
										type="text"  name="name"
										class="form-control form-control-solid"  
										value="{{$role->name}}"
									/> 
								</div>
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Permission </span>
									</label>
									 @foreach($permission_list as $perms)
									 <div class="form-check mt-1">
										<input class="form-check-input" type="checkbox" 
										value="{{$perms->name}}" 
										name="permissions[]" 
										id="check{{$perms->name}}"  
                  						 {{ in_array($perms->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}
										/>
										<label class="form-check-label" for="check{{$perms->name}}">
											{{$perms->name}}
										</label>
									</div>
									 @endforeach
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
		const defaultImage = 'url(/metronic8/demo8/assets/media/avatars/300-6.jpg)';
		
		// Handle file selection
		$('input[name="avatar"]').on('change', function(e) {
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
			$('input[name="avatar"]').val('');
		});
	});
	</script>
@endsection