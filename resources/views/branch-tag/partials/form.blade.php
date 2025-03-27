<div class="row">
    <div class="col-md-8">
        <div class="mb-5">
            <label class="form-label required">Tag Name</label>
            <input type="text" 
                   name="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $tag->name ?? '') }}"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
     
</div>