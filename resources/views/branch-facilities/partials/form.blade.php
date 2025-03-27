<div class="row">
    <div class="col-md-8">
        <div class="mb-5">
            <label class="form-label required">Facility Name</label>
            <input type="text" 
                   name="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $facility->name ?? '') }}"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-5">
            <label class="form-label {{ isset($facility) ? '' : 'required' }}">Image</label>
            <input type="file" 
                   name="{{ $imageFieldName }}" 
                   class="form-control @error($imageFieldName) is-invalid @enderror"
                   accept="image/*"
                   {{ !isset($facility) ? 'required' : '' }}>
            @error($imageFieldName)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if(isset($facility) && $facility->icon)
        <div class="mb-5">
            <label class="form-label">Current Image</label>
            <img src="{{ Storage::url($facility->icon) }}" 
                 class="img-thumbnail d-block"
                 style="max-width: 200px">
            <small class="text-muted mt-2 d-block">Upload new image to replace</small>
        </div>
        @endif
    </div>
</div>