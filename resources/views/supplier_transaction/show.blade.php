<x-admin-layout :title="__($transaction->name ?? 'Show Transaction')">
    <div class="page-content">
        <div class="container-fluid">
         <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('supplier_transactions.index') }}">{{ __('Transaction') }}</a></li>
                                <li class="breadcrumb-item active">{{ $transaction->name ?? 'Show Transaction' }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ url()->previous() }}" class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
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
                                <span class="card-title">Transaction</span>
                            </div>
                        </div>

                        <div class="card-body">
                            
                        <div class="d-flex justify-content-between mb-3">
                            <span>Cash Memo No:</span>
                            <div>
                                {{ $transaction->cash_memo_no }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Client Id:</span>
                            <div>
                                {{ $transaction->client_id }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Description:</span>
                            <div>
                                {{ $transaction->description }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Bill Amount:</span>
                            <div>
                                {{ $transaction->bill_amount }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Payment Amount:</span>
                            <div>
                                {{ $transaction->payment_amount }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Created By:</span>
                            <div>
                                {{ $transaction->created_by }}
                            </div>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span>Updated By:</span>
                            <div>
                                {{ $transaction->updated_by }}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
