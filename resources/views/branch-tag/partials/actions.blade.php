<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('tags.edit', $tag->id) }}" 
       class="btn btn-icon btn-light-primary btn-sm"
       data-bs-toggle="tooltip" 
       title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    
    <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" 
          class="d-inline-block"
          onsubmit="return confirm('Are you sure to delete this tag?')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="btn btn-icon btn-light-danger btn-sm"
                data-bs-toggle="tooltip" 
                title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>