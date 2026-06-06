<x-admin-layout :title="__('Create Stock')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ __('Stock') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <!-- App Search-->
                            <a href="{{ route('stocks.index') }}" class="btn btn-outline-primary waves-effect waves-light">
                                <i class="fas fa-arrow-left align-middle me-2"></i> {{ __('Back') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Create Stock') }}</h4>
                        </div>
                        <div class="card-body">
                            @if (request()->type === 'sale')
                                <form method="POST" action="{{ route('salesEntry') }}"  role="form" enctype="multipart/form-data">
                                    @csrf
                                    @include('stock.saleForm')
                                </form>
                            @else    
                                <form method="POST" action="{{ route('stocks.store') }}"  role="form" enctype="multipart/form-data">
                                    @csrf
                                    @include('stock.form')
                                </form>
                            @endif
                            
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</x-admin-layout>
