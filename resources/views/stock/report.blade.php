<style>
/* Sticky main header row */
.table thead th {
    position: sticky;
    top: 0;
    z-index: 100;              /* Header row highest */
    background: #212529 !important;
    color: #fff;
}

/* Fixed widths */
th.sl, td.sl { width: 55px; }
th.token, td.token { width: 130px; }
th.status, td.status { width: 120px; }

/* ------------------------------ */
/*  LEFT STICKY HEADER COLUMNS    */
/* ------------------------------ */

/* SL# header */
th.sl {
    position: sticky;
    left: 0;
    z-index: 120 !important;   /* Header above all */
    background: #212529 !important;
}

/* TOKEN NUMBER header */
th.token {
    position: sticky;
    left: 55px;
    z-index: 119 !important;
    background: #212529 !important;
}

/* STATUS header */
th.status {
    position: sticky;
    right: 0;
    z-index: 120 !important;
    background: #212529 !important;
}

/* ------------------------------ */
/*  LEFT STICKY BODY COLUMNS      */
/* ------------------------------ */

/* SL# body */
td.sl {
    position: sticky;
    left: 0;
    z-index: 50;               /* LESS than header */
    background: #fff !important;
}

/* TOKEN NUMBER body */
td.token {
    position: sticky;
    left: 55px;
    z-index: 49;               /* LESS than SL header & token header */
    background: #fff !important;
}

/* STATUS body */
td.status {
    position: sticky;
    right: 0;
    z-index: 50;
    background: #fff !important;
}


</style>


<x-admin-layout :title="__('Stock Report')">
    <div class="page-content">
        <div class="container-fluid">

            <x-toast-message />

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Stock Report') }}</li>
                        </ol>
                        
                        <div class="page-title-right">
                            @can('Access Stock')
                                <a href="{{ route('stock.daily.summary') }}"
                                    class="btn btn-soft-danger">
                                    Daily Stock
                                </a>
                            @endcan
    
                            <a href="{{ route('stocks.index') }}"
                               class="btn btn-outline-primary waves-effect waves-light">
                                <i class="fas fa-arrow-left align-middle me-2"></i>
                                {{ __('Back') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <form action="{{ route('stock.report.generate') }}" method="get" class="row g-3">
                <div class="col-md-2">
                    <label>Start date</label>
                    <input type="date" name="start_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label>End date</label>
                    <input type="date" name="end_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Any</option>
                        <option value="Fresh">In Stock</option>
                        <option value="Sold">Sold</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Product</label>
                    <select name="product_category_id" class="form-control">
                        <option value="">Any</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Product Type</label>
                    <select name="type" class="form-control">
                        <option value="">Any</option>
                        <option value="gold">Gold</option>
                        <option value="diamond">Diamond</option>
                    </select>
                </div>

                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                    <a href="{{ route('stock.report.generate') }}" class="btn btn-secondary mt-2">Clear</a>
                    <a href="{{ route('stock.report.pdf', request()->query()) }}"
                    class="btn btn-danger"
                    target="_blank">
                        <i class="fas fa-file-pdf"></i> Print
                    </a>
                </div>

                <div class="col-md-4">
                    <label>Token Number</label>
                    <div class="input-group">
                        <input type="text"
                            name="token_number"
                            value="{{ request('token_number') }}"
                            class="form-control"
                            placeholder="Enter token">

                        <button type="submit" class="btn-sm btn-success ms-2">
                            Search
                        </button>
                    </div>
                </div>

            </form>

            <!-- TABLE -->
            <div style="max-height: 500px; overflow: auto;">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="sl">SL#</th>
                            <th class="token">Token Number</th>
                            <th>PO Number</th>
                            <th>P. Date</th>
                            <th>Supplier</th>
                            <th>Quantity</th>
                            <th>18K</th>
                            <th>21K</th>
                            <th>22K</th>
                            <th>Stone Weight</th>
                            <th>Total Weight</th>
                            <th>P/Rate</th>
                            <th>S/Rate</th>
                            <th>Selling Date</th>
                            <th class="status">Status</th>
                        </tr>
                    </thead>

                    <tr class="table-light fw-bold">
                            <th colspan="5">Total</th>
                            <th>{{ $totals['qty'] }}</th>
                            <th>{{ number_format($totals['w18k'], 2) }}</th>
                            <th>{{ number_format($totals['w21k'], 2) }}</th>
                            <th>{{ number_format($totals['w22k'], 2) }}</th>
                            <th>{{ number_format($totals['stone'], 2) }}</th>
                            <th>{{ number_format($totals['total_weight'], 2) }}</th>
                            <!--<th>{{ number_format($totals['p_rate'], 2) }}</th>-->
                            <!--<th>{{ number_format($totals['s_rate'], 2) }}</th>-->
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                    </tr>

                    <tbody>
                        @forelse($rows as $row)
                            <tr>
                                <!-- Continuous serial number across pages -->
                                <td class="sl">{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                                <td class="token">{{ $row['new_token'] }}</td>
                                <td>{{ $row['po_number'] }}</td>
                                <td>{{ $row['p_date'] }}</td>
                                <td>{{ $row['supplier'] }}</td>
                                <td>{{ $row['qty'] }}</td>

                                <td>{{ number_format($row['w18k'], 2) }}</td>
                                <td>{{ number_format($row['w21k'], 2) }}</td>
                                <td>{{ number_format($row['w22k'], 2) }}</td>
                                <td>{{ number_format($row['stone'], 2) }}</td>
                                <td>{{ number_format($row['total_weight'], 2) }}</td>

                                <td>{{ number_format($row['p_rate'], 2) }}</td>
                                <td>{{ number_format($row['s_rate'], 2) }}</td>
                                <td>{{ $row['selling_date'] }}</td>

                                <td class="status">
                                    @if($row['status'] === 'Sold')
                                        <span class="badge bg-danger">Sold</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center text-danger">
                                    No data found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $rows->links('pagination::bootstrap-5') }}
            </div>
                
        </div>
    </div>
</x-admin-layout>
