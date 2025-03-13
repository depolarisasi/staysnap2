@extends('layouts.app')
@section('title', 'Edit Rooms')  
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    .image-preview-item {
        position: relative;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    .image-preview-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .delete-photo-checkbox {
        position: absolute;
        top: 5px;
        right: 5px;
        z-index: 2;
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Room - {{ $room->name }}</h3>
                            <div class="card-toolbar">
                                <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                @include('rooms.partials.form')
                
                                <!-- Current Photos -->
                                <div class="mb-5">
                                    <label class="form-label">Existing Photos</label>
                                    <div class="image-preview-container">
                                        @foreach($room->photos as $photo)
                                        <div class="image-preview-item">
                                            <img src="{{ Storage::url($photo->path) }}" alt="Room photo">
                                            <div class="p-2 text-center">
                                                <input type="checkbox" 
                                                       name="deleted_photos[]" 
                                                       value="{{ $photo->id }}" 
                                                       id="delete-photo-{{ $photo->id }}"
                                                       class="delete-photo-checkbox">
                                                <label class="form-check-label text-danger" 
                                                       for="delete-photo-{{ $photo->id }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                
                                <div class="text-end mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Room
                                    </button>
                                </div>
                            </form>
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
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select amenities/policies",
            allowClear: true
        });

        // Delete photo confirmation
        $('.delete-photo-checkbox').on('change', function() {
            if(this.checked) {
                if(!confirm('Are you sure to delete this photo?')) {
                    this.checked = false;
                }
            }
        });
    });
</script>
@endsection