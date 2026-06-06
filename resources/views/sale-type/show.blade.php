<x-admin-layout :title="__($saleType->name ?? 'Show Sale Type')">
    <div class="page-content">
        <div class="container-fluid">
         <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('sale-types.index') }}">{{ __('Sale Type') }}</a></li>
                                <li class="breadcrumb-item active">{{ $saleType->name ?? 'Show Sale Type' }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('sale-types.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
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
                                <span class="card-title">Sale Type</span>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('sale-types.index') }}"> Back</a>
                            </div>
                        </div>

                        <div class="card-body">
                            
                        <div class="d-flex justify-content-between mb-3">
                            <span>Name:</span>
                            <div>
                                {{ $saleType->name }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Status:</span>
                            <div>
                                {{ $saleType->status }}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
