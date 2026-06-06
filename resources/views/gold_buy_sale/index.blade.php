<style>
.table-responsive {
    max-height: 70vh;
    overflow: auto;
}

.table-responsive thead th {
    position: sticky;
    top: 0;
    z-index: 2;
}
</style>

<x-admin-layout :title="__('Gold Buy Sale')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ __('Gold Buy Sale') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            @can('Create Gold Buy Sale')
                                <a href="{{ route('create-gold-buy-sale') }}" class="btn btn-soft-success waves-effect waves-light">
                                    <i class="fas fa-plus align-middle me-2"></i> {{ __('Entry') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('gold-buy-sale') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label for="purchase_memo" class="form-label">{{ __('Purchase Memo') }}</label>
                                    <input
                                        type="text"
                                        id="purchase_memo"
                                        name="purchase_memo"
                                        class="form-control"
                                        placeholder="{{ __('Enter Memo') }}"
                                        value="{{ request('purchase_memo') }}"
                                    >
                                </div>

                                <div class="col-md-2">
                                    <label for="date_from" class="form-label">{{ __('From Date') }}</label>
                                    <input
                                        type="date"
                                        id="date_from"
                                        name="date_from"
                                        class="form-control"
                                        value="{{ request('date_from') }}"
                                    >
                                </div>

                                <div class="col-md-2">
                                    <label for="date_to" class="form-label">{{ __('To Date') }}</label>
                                    <input
                                        type="date"
                                        id="date_to"
                                        name="date_to"
                                        class="form-control"
                                        value="{{ request('date_to') }}"
                                    >
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Search') }}</button>
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <a href="{{ route('gold-buy-sale') }}" class="btn btn-secondary w-100">{{ __('Reset') }}</a>
                                </div>
                            </form><br>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-centered align-middle text-nowrap">

                                <thead class="table-dark">
                                    <tr>
                                        <th>SL#</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Purchase Memo') }}</th>
                                        <th>{{ __('Cash Memo') }}</th>

                                        <th>{{ __('Exchange Gold Amount') }}</th>
                                        <th>{{ __('Exchange Carat') }}</th>
                                        <th>{{ __('Exchange Weight') }}</th>

                                        <th>{{ __('Customer Gold Amount') }}</th>
                                        <th>{{ __('Customer Carat') }}
                                        <th>{{ __('Customer Weight') }}</th>

                                        <th>{{ __('Senco Amount') }}</th>
                                        <th>{{ __('Senco Carat') }}</th>
                                        <th>{{ __('Senco Weight') }}</th>

                                        <th>{{ __('Sales Return Amount') }}</th>
                                        <th>{{ __('Sales Carat') }}</th>
                                        <th>{{ __('Sales Weight') }}</th>

                                        <th>{{ __('Total Amount') }}</th>
                                        <th>{{ __('Remarks') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($goldBuySales as $entry)
                                        <tr>
                                            <td>{{ $goldBuySales->firstItem() + $loop->index }}</td>
                                            <td>{{ $entry->date }}</td>
                                            <td>{{ $entry->purchase_memo }}</td>
                                            <td>{{ $entry->cash_memo }}</td>

                                            <td>{{ $entry->exchange_gold_amount }}</td>
                                            <td>{{ $entry->exchange_gold_carat }}</td>
                                            <td>{{ $entry->exchange_gold_weight }}</td>

                                            <td>{{ $entry->customer_gold_amount }}</td>
                                            <td>{{ $entry->customer_gold_carat }}</td>
                                            <td>{{ $entry->customer_gold_weight }}</td>

                                            <td>{{ $entry->senco_amount }}</td>
                                            <td>{{ $entry->senco_carat }}</td>
                                            <td>{{ $entry->senco_weight }}</td>

                                            <td>{{ $entry->sales_return_amount }}</td>
                                            <td>{{ $entry->sales_return_carat }}</td>
                                            <td>{{ $entry->sales_return_weight }}</td>

                                            <td>{{ $entry->total_amount }}</td>
                                            <td>{{ $entry->remarks }}</td>

                                            <td>
                                                @can('Edit Gold Buy Sale')
                                                    <a href="{{ route('edit-gold-buy-sale', $entry->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                        {{ __('Edit') }}
                                                    </a>
                                                @endcan

                                                @can('Delete Gold Buy Sale')
                                                    <form action="{{ route('delete-gold-buy-sale', $entry->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('{{ __('Are you sure?') }}')">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="18" class="text-center text-muted">
                                                {{ __('No records found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            </div>

                            <!-- Pagination -->
                            {{ $goldBuySales->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
