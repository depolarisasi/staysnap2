@extends('layouts.app')
@section('title', 'Rooms') 
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                            <h3 class="card-title">Create New Room</h3>
                            <div class="card-toolbar">
                                <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                @include('rooms.partials.form', [
                                    'room' => new App\Models\Room() // ← Tambahkan ini
                                ])
                
                                <div class="text-end mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Room
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
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('photo-preview');
    previewContainer.innerHTML = '';
    
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail m-2';
            img.style.maxHeight = '150px';
            previewContainer.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});
    </script>
@endsection