@extends('layouts.app')
@section('title', 'Branch') 
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
								 <a href="{{url('management/config/branch/new')}}" class="btn btn-primary">
								 <i class="ki-duotone ki-plus fs-2"></i>Add Branch
							  </a>
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
											<th class="min-w-125px">Branch Name</th>
											<th class="min-w-125px">Address</th>
											<th class="min-w-125px">Phone</th>
											<th class="min-w-125px">Website</th>
											<th class="text-end min-w-100px">Actions</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
										@foreach($branch as $branch)
										<tr>
											<td class="d-flex align-items-center"> 
												<div class="d-flex flex-column">
													<img src="{{asset('storage/'.$branch->branch_logo)}}" class="img-fluid" style="width: 50% !important" alt="" />
													<p class="text-gray-800 text-hover-primary mb-1 mt-2">{{ $branch->branch_name }}</p> 
												</div>
											</td>
											<td>{{ $branch->branch_address }}</td>
											<td>
												<div class="badge badge-light fw-bold">{{ $branch->branch_phone }}</div>
											</td>
											<td>{{ $branch->branch_web }}</td> 
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
														<a href="{{url('management/config/branch/detail/'.$branch->id)}}" class="menu-link px-3">Detail</a>
													</div>
													<!--end::Menu item--> 
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="{{url('management/config/branch/edit/'.$branch->id)}}" class="menu-link px-3">Edit</a>
													</div>
													<!--end::Menu item--> 
													<!--begin::Menu item--> 
													<div class="menu-item px-3">
														<a href="#"><span href="{{url('management/config/branch/delete/'.$branch->id)}}" class="delete menu-link px-3"> Delete</span></a>
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