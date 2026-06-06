<div class="row">
    <div class="col-12">
        @foreach (session('toasts', collect())->toArray() as $toast)
            <div class="alert alert-{{ $toast['type'] }} alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ $toast['title'] }}</strong> {{ $toast['message'] }}
            </div>
        @endforeach
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
