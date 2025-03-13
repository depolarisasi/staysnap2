@props([
    'id',
    'editRoute',
    'pricingRoute', 
    'availabilityRoute',
    'deleteRoute'
])

<div class="d-flex justify-content-end gap-2">
    <!-- Edit Button -->
    <a href="{{ $editRoute }}" 
       class="btn btn-icon btn-light-primary btn-sm"
       data-bs-toggle="tooltip" 
       title="Edit">
        <i class="fas fa-edit fs-4"></i>
    </a>

    <!-- Pricing Management -->
    <a href="{{ $pricingRoute }}" 
       class="btn btn-icon btn-light-info btn-sm"
       data-bs-toggle="tooltip" 
       title="Pricing">
        <i class="fas fa-dollar-sign fs-4"></i>
    </a>

    <!-- Availability Management -->
    <a href="{{ $availabilityRoute }}" 
       class="btn btn-icon btn-light-warning btn-sm"
       data-bs-toggle="tooltip" 
       title="Availability">
        <i class="fas fa-calendar-alt fs-4"></i>
    </a>

    <!-- Delete Button -->
    <form action="{{ $deleteRoute }}" method="POST" class="d-inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="btn btn-icon btn-light-danger btn-sm delete-btn"
                data-bs-toggle="tooltip" 
                title="Delete">
            <i class="fas fa-trash fs-4"></i>
        </button>
    </form>
</div>