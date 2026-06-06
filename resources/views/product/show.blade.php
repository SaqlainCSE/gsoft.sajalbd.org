<x-admin-layout :title="__($product->name ?? 'Show Product')">
    <div class="page-content">
        <div class="container-fluid">
         <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">{{ __('Product') }}</a></li>
                                <li class="breadcrumb-item active">{{ $product->name ?? 'Show Product' }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('products.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
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
                                <span class="card-title">Product</span>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                            </div>
                        </div>

                        <div class="card-body">
                            
                        <div class="d-flex justify-content-between mb-3">
                            <span>Product Nr:</span>
                            <div>
                                {{ $product->product_nr }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Product Details:</span>
                            <div>
                                {{ $product->product_details }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Weight:</span>
                            <div>
                                {{ $product->weight }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Price:</span>
                            <div>
                                {{ $product->price }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Created By:</span>
                            <div>
                                {{ $product->created_by }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Updated By:</span>
                            <div>
                                {{ $product->updated_by }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Deleted By:</span>
                            <div>
                                {{ $product->deleted_by }}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
