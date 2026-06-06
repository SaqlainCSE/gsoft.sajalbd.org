<x-admin-layout :title="__($stock->name ?? 'Show Stock')">
    <div class="page-content">
        <div class="container-fluid">
         <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('stocks.index') }}">{{ __('Stock') }}</a></li>
                                <li class="breadcrumb-item active">{{ $stock->name ?? 'Show Stock' }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('stocks.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
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
                                <span class="card-title">Stock</span>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('stocks.index') }}"> Back</a>
                            </div>
                        </div>

                        <div class="card-body">
                            
                        <div class="d-flex justify-content-between mb-3">
                            <span>Date:</span>
                            <div>
                                {{ $stock->date }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Memo:</span>
                            <div>
                                {{ $stock->memo }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Token:</span>
                            <div>
                                {{ $stock->token }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Client Id:</span>
                            <div>
                                {{ $stock->client_id }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Unit 18K:</span>
                            <div>
                                {{ $stock->unit_18k }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Unit 21K:</span>
                            <div>
                                {{ $stock->unit_21k }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Unit 22K:</span>
                            <div>
                                {{ $stock->unit_22k }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>St:</span>
                            <div>
                                {{ $stock->st }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>D18K:</span>
                            <div>
                                {{ $stock->d18k }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Dia:</span>
                            <div>
                                {{ $stock->dia }}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
