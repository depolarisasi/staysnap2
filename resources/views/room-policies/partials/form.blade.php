<div class="row">
    <div class="col-md-8">
        <div class="mb-5">
            <label class="form-label required">Policy Name</label>
            <input type="text" 
                   name="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $roomPolicy->name ?? '') }}"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-5">
            <label class="form-label">Description</label>
            <textarea name="description" 
                      class="form-control @error('description') is-invalid @enderror" 
                      rows="3">{{ old('description', $roomPolicy->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>