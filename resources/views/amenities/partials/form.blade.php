<div class="row">
    <div class="col-md-8">
        <div class="mb-5">
            <label class="form-label required">Amenity Name</label>
            <input type="text" 
                   name="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $amenity->name ?? '') }}"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-5">
            <label class="form-label {{ isset($amenity) ? '' : 'required' }}">Image</label>
            <input type="file" 
                   name="{{ $imageFieldName }}" 
                   class="form-control @error($imageFieldName) is-invalid @enderror"
                   accept="image/*"
                   {{ !isset($amenity) ? 'required' : '' }}>
            @error($imageFieldName)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if(isset($amenity) && $amenity->icon)
        <div class="mb-5">
            <label class="form-label">Current Image</label>
            <img src="{{ Storage::url($amenity->icon) }}" 
                 class="img-thumbnail d-block"
                 style="max-width: 200px">
            <small class="text-muted mt-2 d-block">Upload new image to replace</small>
        </div>
        @endif
    </div>
</div>