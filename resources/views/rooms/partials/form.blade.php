<div class="row">
    <!-- Left Column -->
    <div class="col-md-8">
        @if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

        <!-- Basic Info -->
        <div class="mb-5">
            <label class="form-label required">Room Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $room->name ?? '') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Branch Selection -->
        <div class="mb-5">
            <label class="form-label required">Branch</label>
            <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" 
                        {{ old('branch_id', $room->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
            @error('branch_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
 
        <div class="row mb-5"> 
            <div class="col-md-3">
                <label class="form-label required">Base Price</label>
                <input type="number" name="base_price" 
                       class="form-control @error('base_price') is-invalid @enderror"
                       value="{{ old('base_price', $room->base_price ?? '') }}">
                @error('base_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label required">Room Size</label>
                <input type="text" 
                       name="room_size" 
                       class="form-control @error('room_size') is-invalid @enderror" 
                       value="{{ old('room_size', $room->room_size ?? '') }}"
                       required>
                @error('room_size')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label required">Capacity</label>
                <input type="number" name="capacity" 
                       class="form-control @error('capacity') is-invalid @enderror"
                       value="{{ old('capacity', $room->capacity ?? '') }}">
                @error('capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label required">Stock</label>
                <input type="number" name="stock" 
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', $room->stock ?? '') }}">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="mb-5">
            <label class="form-label required">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                      rows="4">{{ old('description', $room->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-md-4">
        <!-- Status -->
        <div class="mb-5">
            <label class="form-label required">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                @foreach(['operational' => 'Operational', 'maintenance' => 'Maintenance', 'closed' => 'Closed'] as $value => $label)
                    <option value="{{ $value }}" 
                        {{ old('status', $room->status ?? '') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Amenities Selection -->
        <div class="mb-5">
            <label class="form-label">Amenities</label>
            <div class="row g-4">
                @foreach($amenities as $amenity)
                <div class="col-md-4">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" 
                            type="checkbox" 
                            name="amenities[]" 
                            value="{{ $amenity->id }}" 
                            id="amenity-{{ $amenity->id }}"
                            @if(isset($room) && $room->amenities->contains($amenity->id)) checked @endif
                            @if(in_array($amenity->id, old('amenities', []))) checked @endif>
                        <label class="form-check-label" for="amenity-{{ $amenity->id }}">
                            @if($amenity->path)
                            <img src="{{ Storage::url($amenity->path) }}" 
                                class="img-thumbnail mb-2"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            @endif
                            {{ $amenity->name }}
                        </label>
                    </div>
                </div>
                @endforeach
                @error('amenities')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>


    <!-- Policies Selection -->
        <div class="mb-5">
            <label class="form-label">Policies</label>
            <div class="row g-4">
                @foreach($policies as $policy)
                <div class="col-md-6">
                    <div class="form-check form-check-custom form-check-solid"> 
                        <input class="form-check-input" 
                            type="checkbox" 
                            name="policies[]" 
                            value="{{ $policy->id }}" 
                            id="policy-{{ $policy->id }}"
                            @if(isset($room) && $room->policies->contains($policy->id)) checked @endif
                            @if(in_array($policy->id, old('policies', []))) checked @endif>
                        <label class="form-check-label" for="policy-{{ $policy->id }}">
                            <span class="fw-bold">{{ $policy->name }}</span> 
                        </label>
                    </div>
                </div>
                @endforeach
                @error('policies')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Photo Upload -->
        <div class="mb-5">
            <label class="form-label">Photos</label>
            <input type="file" name="photos[]" multiple 
                   class="form-control @error('photos.*') is-invalid @enderror"
                   accept="image/*">
                @error('photos.*')
                   <div class="invalid-feedback">{{ $message }}</div>
               @enderror
               @error('photos')
                   <div class="invalid-feedback">{{ $message }}</div>
               @enderror
        </div>
    </div>
</div>