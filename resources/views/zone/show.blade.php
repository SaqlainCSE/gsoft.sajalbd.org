<x-admin-layout :title="__($zone->name ?? 'Show Zone')">
    <div class="page-content">
        <div class="container-fluid">
         <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('zones.index') }}">{{ __('Zone') }}</a></li>
                                <li class="breadcrumb-item active">{{ $zone->name ?? 'Show Zone' }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('zones.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
                                <i class="fas fa-arrow-left align-middle me-2"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <span class="card-title">Zone</span>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('zones.index') }}"> Back</a>
                            </div>
                        </div>

                        <div class="card-body">
                            
                        <div class="d-flex justify-content-between mb-3">
                            <span>Name:</span>
                            <div>
                                {{ $zone->name }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>District Id:</span>
                            <div>
                                {{ $zone->district_id }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Note:</span>
                            <div>
                                {{ $zone->note }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Status:</span>
                            <div>
                                {{ $zone->status }}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
