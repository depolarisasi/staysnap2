@extends('layouts.app')
@section('title', 'Edit Branch') 
@section('styles')
<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/> 
<style>
	.select2-container--disabled {
			background-color: #f8f9fa;
			opacity: 1;
		}
		.select2-container--default .select2-selection--multiple {
		border: 1px solid #ced4da;
		min-height: 38px;
	}
	
	.select2-container--default .select2-selection--multiple .select2-selection__choice {
		background-color: #e9ecef;
		border-color: #dee2e6;
		color: #212529;
	}
	
	select2-container--default .select2-selection--multiple .select2-selection__choice {
		background-color: #e4e6ef;
		border: 1px solid #ddd;
		color: #333;
	}
	
	.select2-container--default .select2-results__option[aria-disabled=true] {
		display: none;
	}
		</style>
@endsection
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
								 <a class="btn btn-sm btn-secondary" href="{{url('management/config/branch')}}">
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
									<select class="form-control select2-province" id="province" name="branch_province">
										@if($branch->province)
											<option value="{{ $branch->branch_province }}" selected>{{ $branch->province->province }}</option>
										@endif
									</select>
									<div id="province-loading" class="text-muted small mt-1" style="display: none;">
										<i class="fas fa-spinner fa-spin"></i> Loading provinces...
									</div>
									<div id="province-error" class="text-danger small mt-1"></div>
								</div>

								<!-- Email Input -->
								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Branch City</span>
									</label>
									<select class="form-control select2-regency" id="regency" name="branch_city">
										@if($branch->regency)
											<option value="{{ $branch->branch_city }}" selected>{{ $branch->regency->regency }}</option>
										@endif
									</select>
									<div id="regency-loading" class="text-muted small mt-1" style="display: none;">
										<i class="fas fa-spinner fa-spin"></i> Loading cities...
									</div>
									<div id="regency-error" class="text-danger small mt-1"></div>
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

								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Branch Description</span>
									</label>
									<textarea required name="branch_description" class="form-control form-control form-control-solid"> {{$branch->branch_description}}</textarea> 
								</div>
							

								<div class="d-flex flex-column mb-8 fv-row">
									<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
										<span class="required">Branch Tag</span>
									</label>
									<select name="tags[]" class="form-control select2-tags" multiple="multiple">
										{{-- Untuk Edit Form --}}
										@isset($branch)
											@foreach($branch->tags as $tag)
												<option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
											@endforeach
										@endisset
									</select>
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

								  <!-- Amenities Selection -->
								  <div class="mb-5 fv-row mt-5">
									<label class="form-label">Branch Facilities</label>
									<div class="row g-4">
										@foreach($facilities as $facility)
										<div class="col-md-4">
											<div class="form-check form-check-custom form-check-solid">
												<input class="form-check-input" 
													type="checkbox" 
													name="facilities[]" 
													value="{{ $facility->id }}" 
													id="facility-{{ $facility->id }}"
													@if(isset($branch) && $branch->facilities->contains($facility->id)) checked @endif
													@if(in_array($facility->id, old('facilities', []))) checked @endif>
												<label class="form-check-label" for="facility-{{ $facility->id }}">
													@if($facility->path)
													<img src="{{ Storage::url($facility->path) }}" 
														class="img-thumbnail mb-2"
														style="width: 60px; height: 60px; object-fit: cover;">
													@endif
													{{ $facility->name }}
												</label>
											</div>
										</div>
										@endforeach
										@error('facilities')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
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
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script> 
 

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

<script>
	$(document).ready(function() {
		// Initialize Province Select2 dengan data existing
		var provinceSelect = $('.select2-province');
		var initialProvinceId = {{ $branch->branch_province ?? 'null' }};
		
		provinceSelect.select2({
			placeholder: 'Cari Provinsi...',
			allowClear: true,
			ajax: {
				url: '/provinces',
				dataType: 'json',
				delay: 300,
				data: function(params) {
					return { search: params.term };
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								id: item.id,
								text: item.province
							}
						})
					};
				}
			}
		});
	
		// Jika ada data existing, trigger load regencies
		if(initialProvinceId) {
			// Load regencies untuk province yang dipilih
			$.ajax({
				url: '/regencies/' + initialProvinceId,
				type: "GET",
				dataType: "json",
				beforeSend: function() {
					$('#regency').prop('disabled', true);
					$('#regency-loading').show();
				},
				success: function(data) {
					var regencySelect = $('#regency');
					regencySelect.empty();
					
					// Tambahkan option existing
					regencySelect.append(
						`<option value="{{ $branch->branch_city }}" selected>{{ $branch->regency->regency }}</option>`
					);
					
					// Tambahkan data lain
					$.each(data, function(key, value) {
						if(value.id != {{ $branch->branch_city }}) {
							regencySelect.append(
								`<option value="${value.id}">${value.regency}</option>`
							);
						}
					});
					
					regencySelect.prop('disabled', false);
					regencySelect.trigger('change');
				},
				complete: function() {
					$('#regency-loading').hide();
				}
			});
		}
	
		// Initialize Regency Select2
		var regencySelect = $('.select2-regency').select2({
			placeholder: 'Pilih Kabupaten/Kota',
			allowClear: true
		});
	
		// Province Change Handler
		$('#province').on('change', function() {
        var provinceID = $(this).val();
        var $regency = $('#regency');
        
        if(provinceID) {
            $regency.prop('disabled', true); 
            $('#regency-error').hide();

            $.ajax({
                url: '/regencies/' + provinceID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $regency.empty().append('<option value="">Select Regency</option>');
                    $.each(data, function(key, value) {
                        $regency.append(
                            `<option value="${value.id}">${value.regency}</option>`
                        );
                    });
                    $regency.prop('disabled', false).trigger('change');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#regency-error').html('Failed to load regencies. Please try again.').show();
                    $regency.empty().append('<option value="">Error loading data</option>');
                },
                 
            });
        } else {
            $regency.empty().append('<option value="">Select Province First</option>');
            $regency.prop('disabled', true);
        }
    });

    // Initialize Regency Select2
    $('.select2-regency').select2({
        placeholder: 'Select City / Regency',
        allowClear: true
    });
});
	</script>



<script>
	$(document).ready(function() {
		// Province Select2
		$('.select2-province').select2({
			ajax: {
				url: '/provinces',
				dataType: 'json',
				processResults: function(data) {
					return {
						results: data.map(function(province) {
							return {
								id: province.id,
								text: province.province
							}
						})
					};
				}
			}
		});
	
		// Regency Select2
		$('.select2-regency').select2({
			ajax: {
				url: function() {
					const provinceId = $('.select2-province').val();
					return `/regencies/${provinceId}`;
				},
				dataType: 'json',
				processResults: function(data) {
					return {
						results: data.map(function(regency) {
							return {
								id: regency.id,
								text: regency.regency
							}
						})
					};
				}
			}
		});
	
		// Tags Select2
		$('.select2-tags').select2({
        tags: false, // Pastikan ini false
        ajax: {
            url: '/management/config/branch/tags/search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            }
        },
        minimumInputLength: 1 // User harus mengetik minimal 1 karakter
    });
	});
	</script>
@endsection