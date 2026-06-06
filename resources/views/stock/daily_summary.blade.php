<x-admin-layout :title="__('Daily Stock')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ __('Daily Stock') }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right">
                            <a href="{{ route('stock.report.generate') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <form class="mb-4" method="GET" action="{{ route('stock.daily.summary') }}">
                <label>Date</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="form-control d-inline-block" style="width:200px;">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('stock.daily.summary') }}" class="btn btn-secondary ms-2">Clear</a>
                <a href="{{ route('stock.daily.summary.pdf', ['date' => request('date')]) }}"
                class="btn btn-danger ms-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Print
                </a>
            </form>

            <!-- MAIN STOCK TABLE -->
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>SL#</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Weight (gm)</th>
                        <th>18K</th>
                        <th>21K</th>
                        <th>22K</th>
                        <th>Stone</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($rows as $r)
                    <tr>
                        <td>{{ $r['sl'] }}</td>
                        <td>{{ $r['category'] }}</td>
                        <td>{{ $r['qty'] }}</td>
                        <td>{{ number_format($r['total_weight'], 2) }}</td>
                        <td>{{ number_format($r['w18k'],2) }}</td>
                        <td>{{ number_format($r['w21k'],2) }}</td>
                        <td>{{ number_format($r['w22k'],2) }}</td>
                        <td>{{ number_format($r['stone'],2) }}</td>
                    </tr>
                    @endforeach

                    <!-- TOTAL ROW -->
                    <tr class="fw-bold" style="background:#eee;">
                        <td colspan="2">TOTAL</td>
                        <td>{{ $totals['qty'] }}</td>

                        <!-- TOTAL WEIGHT -->
                        <td>
                            {{ number_format($totals['total_weight'], 2) }} (gm)
                            <br>
                            <strong>{{ number_format($totals['total_weight_vori'], 3) }} (vori)</strong>
                        </td>

                        <!-- 18K -->
                        <td>
                            {{ number_format($totals['w18k'], 2) }} (gm)
                            <br>
                            <strong>{{ number_format($totals['w18k_vori'], 3) }} (vori)</strong>
                        </td>

                        <!-- 21K -->
                        <td>
                            {{ number_format($totals['w21k'], 2) }} (gm)
                            <br>
                            <strong>{{ number_format($totals['w21k_vori'], 3) }} (vori)</strong>
                        </td>

                        <!-- 22K -->
                        <td>
                            {{ number_format($totals['w22k'], 2) }} (gm)
                            <br>
                            <strong>{{ number_format($totals['w22k_vori'], 3) }} (vori)</strong>
                        </td>

                        <!-- STONE -->
                        <td>{{ number_format($totals['stone'], 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- DIAMOND PRODUCT TABLE -->
            <h4 class="mt-4 mb-3">Diamond Products</h4>

            <table class="table table-bordered table-striped table-hover mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>SL#</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Weight (gm)</th>
                        <th>18K</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($diamondRows as $dr)
                    <tr>
                        <td>{{ $dr['sl'] }}</td>
                        <td>{{ $dr['product'] }}</td>
                        <td>{{ $dr['qty'] }}</td>
                        <td>{{ number_format($dr['weight'],2) }}</td>
                        <td>{{ number_format($dr['w18k'],2) }}</td>
                    </tr>
                    @endforeach

                    <tr class="fw-bold" style="background:#eee;">
                        <td colspan="2">TOTAL</td>
                        <td>{{ $diamondTotals['qty'] }}</td>
                        <td>{{ number_format($diamondTotals['weight'],2) }} (gm)</td>
                        <td>{{ number_format($diamondTotals['w18k'],2) }} (gm)</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</x-admin-layout>
