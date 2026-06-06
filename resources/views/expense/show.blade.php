<x-admin-layout :title="__($expense->name ?? 'Show Expense')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('expenses.index') }}">{{ __('Expense') }}</a></li>
                                <li class="breadcrumb-item active">{{ $expense->name ?? 'Show Expense' }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('expenses.index') }}"
                                class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
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
                                <span class="card-title">Expense</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Expense Head:</span>
                                        <div>
                                            {{ $expense->trxHead?->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Payment Method:</span>
                                        <div>
                                            {{ $expense->paymentMethod?->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Amount:</span>
                                        <div>
                                            {{ bd_money_format($expense->amount) }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Reference No:</span>
                                        <div>
                                            {{ $expense->reference_no }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Date:</span>
                                        <div>
                                            {{ formatted_date($expense->date) }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Note:</span>
                                        <div>
                                            {{ $expense->note }}
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Expense By:</span>
                                        <div>
                                            {{ $expense->expenseBy?->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Created By:</span>
                                        <div>
                                            {{ $expense->creator?->name }} ({{ $expense->created_at->diffForHumans() }})
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Updated By:</span>
                                        <div>
                                            {{ $expense->editor?->name }} ({{ $expense->updated_at->diffForHumans() }})
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin-layout>
