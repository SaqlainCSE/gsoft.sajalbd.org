@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="alert alert-danger alert-dismissible fade show mb-0">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif
