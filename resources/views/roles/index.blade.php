@extends('layouts.app')
@section('title', 'Roles') 
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
					<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
						@foreach($roles as $role)
						<div class="col-md-4">
							<!--begin::Card-->
							<div class="card card-flush h-md-100">
								<!--begin::Card header-->
								<div class="card-header">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>{{$role->name}}</h2>
									</div>
									<!--end::Card title-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body pt-1">
									<!--begin::Users--> 
									<!--end::Users-->
									<!--begin::Permissions-->
									<div class="d-flex flex-column text-gray-600">
										@foreach($role->permissions as $permission)
										<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>{{$permission->name}}</div> 
										@endforeach
									</div>
									<!--end::Permissions-->
								</div>
								<!--end::Card body-->
								<!--begin::Card footer-->
								<div class="card-footer flex-wrap pt-0"> 
									<a href="{{url('management/role/edit/'.$role->id)}}" class="btn btn-light btn-active-light-primary my-1">Edit Role</a>
									<a href="#"><span href="{{url('management/role/delete/'.$role->id)}}" class="delete btn btn-light btn-active-light-primary my-1"> Delete Role</span></a> 
								</div>
								<!--end::Card footer-->
							</div>
							<!--end::Card-->
						</div>
						@endforeach
						<div class="ol-md-4">
							<!--begin::Card-->
							<div class="card h-md-100">
								<!--begin::Card body-->
								<div class="card-body d-flex flex-center">
									<!--begin::Button-->
									<button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" 
							data-bs-target="#modal_add_user">
							<img src="{{asset('assets/media/illustrations/sketchy-1/4.png')}}" alt="" class="mw-100 mh-150px mb-7">
							<i class="ki-duotone ki-plus fs-2"></i>Add Roles
							</button>
									
								</div>
								<!--begin::Card body-->
							</div>
							<!--begin::Card-->
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

<!-- Modal Edit -->
<div  class="modal fade" id="modal_add_user" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content rounded">
			<div class="modal-header pb-0 border-0 justify-content-end">
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="ki-duotone ki-cross fs-1">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
				</div>
			</div>
			
			<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
				<form action="{{url('management/role/store')}}" method="POST">
					@csrf
					<div class="mb-13 text-center">
						<h1 class="mb-3">Add Roles</h1>
						<div class="text-muted fw-semibold fs-5">
							Add new Role
						</div>
					</div>
					 
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Role Name </span>
						</label>
						<input 
							type="text"  name="name"
							class="form-control form-control-solid" 
							placeholder="role name"
						/> 
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Permission </span>
						</label>
						 @foreach($permission_list as $perms)
						 <div class="form-check mt-1">
							<input class="form-check-input" type="checkbox" value="{{$perms->name}}" name="permissions[]" id="check{{$perms->name}}" />
							<label class="form-check-label" for="check{{$perms->name}}">
								{{$perms->name}}
							</label>
						</div>
						 @endforeach
					</div>

					<div class="text-center">
						<button 
							type="button" 
							class="btn btn-light me-3" 
							data-bs-dismiss="modal"
						>
							Batal
						</button>
						<button type="submit" class="btn btn-primary">
							<span class="indicator-label">Submit</span> 
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
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