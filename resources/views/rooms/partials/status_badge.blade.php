@props(['status'])

@php
    $statusClasses = [
        'operational' => 'badge-light-success',
        'maintenance' => 'badge-light-warning',
        'closed' => 'badge-light-danger'
    ][$status ?? 'operational'];
@endphp

<span class="badge {{ $statusClasses }} fs-7 fw-bold py-2 px-3">
    {{ ucfirst($status) }}
</span>