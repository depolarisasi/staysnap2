@extends('layouts.app')
@section('title', 'Branch Detail') 
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
					<div class="card card-flush py-4 flex-row-fluid">
						<!--begin::Card header-->
						<div class="card-header">
							<div class="card-title">
								<h2>Branch Details - {{$branch->branch_name}}</h2>
							</div>
							<!--begin::Toolbar-->
							<div class="card-toolbar">
								<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
									
									<a class="btn btn-sm btn-warning" href="{{url('management/config/branch/edit/'.$branch->id)}}">
										<i class="ki-solid ki-pencil fs-2"></i>Edit</a>  
									<a class="btn btn-sm btn-secondary mx-2" href="{{url('management/config/branch')}}">
									<i class="ki-solid ki-left fs-2"></i>Kembali</a> 
								</div>
							</div>
							 <!--end::Toolbar-->    
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<div class="table-responsive">
								<!--begin::Table-->
								<table class="table table-row-bordered mb-0 fs-6 gy-5">
									<tbody class="fw-semibold text-gray-600">
										<tr>
											<td>
												<div class="d-flex align-items-center">
												 Branch Name</div>
											</td>
											<td class="fw-bold">{{$branch->branch_name}}</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												 Branch Address</div>
											</td>
											<td class="fw-bold">{{$branch->branch_address}}</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Star</div>
											</td>
											<td class="fw-bold">{{$branch->branch_star}}</td>
										</tr>
										
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Province</div>
											</td>
											<td class="fw-bold">{{$branch->province->province}}</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch City</div>
											</td>
											<td class="fw-bold">{{$branch->regency->regency}}</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Phone</div>
											</td>
											<td class="fw-bold">{{$branch->branch_phone}}</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Website</div>
											</td>
											<td class="fw-bold">{{$branch->branch_web}}</td>
										</tr>
										
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Map Link</div>
											</td>
											<td class="fw-bold">{{$branch->branch_maps_link}}</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Description</div>
											</td>
											<td class="fw-bold">{{$branch->branch_description}}</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Tags</div>
											</td>
											<td class="fw-bold">@foreach($branch->tags as $tag)
												<span class="badge badge-secondary">{{$tag->name}}</span></option>
											@endforeach
										</td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Facilities</div>
											</td>
											<td class="fw-bold">
												<div class="row">
													<!-- Kolom Pertama -->
													<div class="col-md-6">
														<ul>
															@foreach($branch->facilities->take(15) as $facility)
																<li>{{ $facility->name }}</li>
															@endforeach
														</ul>
													</div>
												
													<!-- Kolom Kedua (jika ada lebih dari 15 item) -->
													@if($branch->facilities->count() > 15)
													<div class="col-md-6">
														<ul>
															@foreach($branch->facilities->slice(15) as $facility)
																<li>{{ $facility->name }}</li>
															@endforeach
														</ul>
													</div>
													@endif
												</div></td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Logo</div>
											</td>
											<td class="fw-bold"><img src="{{asset('storage/'.$branch->branch_logo)}}" class="img-fluid"></td>
										</tr>
										<tr>
											<td>
												<div class="d-flex align-items-center">
												Branch Thumbnail Photos</div>
											</td>
											<td class="fw-bold"><img src="{{asset('storage/'.$branch->branch_thumbnail)}}" class="img-fluid" style="max-width: 50% !important;"></td>
										</tr>

									</tbody>
								</table>
								<!--end::Table-->
							</div>
						</div>
						<!--end::Card body-->
					</div>
				</div>
				 
			</div>
			<!--end::Row-->
			<div class="d-flex flex-wrap flex-stack my-5">
				<!--begin::Heading-->
				<h3 class="fw-bold my-2">Branch Photos </h3>
				<!--end::Heading--> 
			</div>
			<div class="row g-6 g-xl-9 mb-6 mb-xl-9">
				@if(isset($branch) && $branch->photos->count() > 0)
				<!--begin::Col-->
				@foreach($branch->photos as $photos)
				<div class="col-md-6 col-lg-4 col-xl-3">
					<!--begin::Card-->
					<div class="card h-100">
						<!--begin::Card body-->
						<div class="card-body d-flex justify-content-center text-center flex-column p-8">
							<!--begin::Overlay-->
<a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{asset('storage/'.$photos->path)}}">
    <!--begin::Image-->
    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
        style="background-image:url({{asset('storage/'.$photos->path)}})">
    </div>
    <!--end::Image-->

    <!--begin::Action-->
    <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
        <i class="bi bi-eye-fill text-white fs-3x"></i>
    </div>
    <!--end::Action-->
</a>
<!--end::Overlay-->

 
							<!--end::Name--> 
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				@endforeach
				<!--end::Col--> 
				@endif
			</div>
		 
		</div>
		<!--end::Container-->
	</div>
	<!--end::Post-->
</div>
<!--end::Content-->
 
@endsection
@section('scripts')  
<script src="{{asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>


<!--begin::Custom Javascript(used for this page only)-->

<script>  
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