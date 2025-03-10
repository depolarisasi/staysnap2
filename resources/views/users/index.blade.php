@extends('layouts.app')
@section('title', 'User') 
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
								 <button type="button" class="btn btn-primary" data-bs-toggle="modal" 
								 data-bs-target="#modal_add_user">
								 <i class="ki-duotone ki-plus fs-2"></i>Add User
								 </button>
								 <!--end::Add user-->
							  </div>
							  <!--end::Toolbar-->    
						   </div>
						   <!--end::Card toolbar-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body py-4">
						   <!--begin::Table-->
						   <div id="table_user_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
							  <div id="" class="table-responsive"> 
								<table class="table align-middle table-row-dashed fs-6 gy-5" id="table_user">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-125px">User</th>
											<th class="min-w-125px">Role</th>
											<th class="min-w-125px">Branch</th>
											<th class="text-end min-w-100px">Actions</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
										@foreach($users as $user)
										<tr>
											<td class="d-flex align-items-center">
												<!--begin:: Avatar -->
												<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
													<a href="#">
														<div class="symbol-label">
															<img src="{{ asset('storage/'.$user->profile_picture) }}" alt="{{ $user->name }}" class="w-100" />
														</div>
													</a>
												</div>
												<!--end::Avatar-->
												<div class="d-flex flex-column">
													<a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $user->name }}</a>
													<span>{{ $user->email }}</span>
													<span>{{ $user->phone_number }}</span>
												</div>
											</td>
											<td>{{ $user->role }}</td>
											<td>
												<div class="badge badge-light fw-bold">{{ $user->branch_name }}</div>
											</td>
											<td class="text-end">
												<!--begin::Action Menu-->
												<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" 
												data-kt-menu-trigger="click" 
												data-kt-menu-placement="bottom-end">
												Actions
												<i class="ki-duotone ki-down fs-5 ms-1"></i>
												</a>
												
												<!--begin::Menu-->
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" 
													data-kt-menu="true"> 
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="{{url('management/user/edit/'.$user->id)}}" class="menu-link px-3">Edit</a>
													</div>
													<!--end::Menu item--> 
													<!--begin::Menu item--> 
													<div class="menu-item px-3">
														<a href="#"><span href="{{url('management/user/delete/'.$user->id)}}" class="delete menu-link px-3"> Delete</span></a>
													</div>
													<!--end::Menu item-->
												</div>
												<!--end::Menu-->
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							  </div>
							 
						   </div>
						   <!--end::Table-->    
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
				<form action="{{url('management/user/store')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="mb-13 text-center">
						<h1 class="mb-3">Add User</h1>
						<div class="text-muted fw-semibold fs-5">
							Add new user
						</div>
					</div>
					
					<div class="fv-row mb-7">
						<label class="d-block fw-semibold fs-6 mb-5">Profile Picture</label> 
						<!-- Image container -->
						<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
							<!-- Preview area -->
							<div class="image-input-wrapper w-125px h-125px" 
								 style="background-image: url({{asset('assets/media/avatars/300-6.jpg')}})">
							</div>
					
							<!-- Change Button -->
							<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
								   data-kt-image-input-action="change" 
								   data-bs-toggle="tooltip" 
								   title="Change Profile Picture">
								<i class="ki-solid ki-pencil fs-7"></i>
								<input type="file" 
									   name="profile_picture" 
									   accept=".png, .jpg, .jpeg" 
									   class="d-none">
								<input type="hidden" name="profile_picture_remove">
							</label>
					
							<!-- Cancel Button -->
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
								  data-kt-image-input-action="cancel" 
								  data-bs-toggle="tooltip" 
								  title="Cancel profile_picture">
								  <i class="ki-solid ki-cross"></i>
							</span>
					
							<!-- Remove Button -->
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
								  data-kt-image-input-action="remove" 
								  data-bs-toggle="tooltip" 
								  title="Remove profile_picture">
								  <i class="ki-solid ki-cross"></i>
							</span>
						</div>
						
						<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
					</div>
					<!-- Name Input -->
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Name </span>
						</label>
						<input 
							type="text"  name="name"
							class="form-control form-control-solid" 
							placeholder="Full Name"
						/> 
					</div>

					<!-- Email Input -->
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Email</span>
						</label>
						<input 
							type="email" name="email" 
							class="form-control form-control-solid" 
							placeholder="Email Address"
						/> 
					</div>

					<!-- Password Input -->
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span>Password</span> 
						</label>
						<input 
							type="password"  
							class="form-control form-control-solid" 
							placeholder="Password"
							name="password"
						/> 
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span>Phone Number</span> 
						</label>
						<input 
							type="text"  
							class="form-control form-control-solid" 
							placeholder="Phone Number"
							name="phone_number"
						/> 
					</div>
 
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span>Role</span> 
						</label>
						<select class="form-select" name="role">
							<option value="">Select Role</option>
							@foreach($roles as $role)
							<option value="{{$role->name}}">{{$role->name}}</option>
							@endforeach 
						</select>
					</div>

					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span>Branch</span> 
						</label>
						<select class="form-select" name="branch_id">
							<option  value="">Select Branch</option> 
							@foreach($branches as $branch)
							<option value="{{$branch->id}}">{{$branch->branch_name}}</option>
							@endforeach
						</select>
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