@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-warning alert-dismissible fade show']) }}>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ $status }}
    </div>
@endif
