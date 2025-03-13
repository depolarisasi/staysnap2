@if(isset($room) && $room->photos->count() > 0)
<div class="mb-5">
    <h5>Existing Photos</h5>
    <div class="row g-5">
        @foreach($room->photos as $photo)
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