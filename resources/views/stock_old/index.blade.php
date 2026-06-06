<x-admin-layout :title="__('Stock')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Stock') }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right">

                            @can('Access Stock')
                                <a href="{{ route('stock.report.generate') }}"
                                    class="btn btn-soft-danger text-uppercase">
                                    REPORT
                                </a>
                            @endcan

                            @can('Add Stock')
                                <a href="{{ route('stocks.create') }}"
                                    class="btn btn-soft-success waves-effect waves-light  text-uppercase">
                                    {{ __('Add Stock') }}
                                </a>
                            @endcan
                            @can('Access Sales Entry')
                                <a href="{{ route('salesEntry') }}" class="btn btn-soft-warning text-uppercase">
                                    {{ __('Sales Entry') }}
                                </a>
                            @endcan
                            @can('Access Sales Entry')
                                <a href="{{ route('stocks.create') }}?type=sale"
                                    class="btn btn-soft-info waves-effect waves-light text-uppercase">
                                    {{ __('Add Sale') }}
                                </a>
                            @endcan

                            @can('Access Stock')
                                <a href="{{ route('stock.saleList') }}"
                                    class="btn btn-soft-secondary text-uppercase">
                                    SALE LIST
                                </a>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <form method="GET" action="{{ route('stock.filter') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 mt-4 pt-2">
                        <button class="btn btn-primary">Filter</button>
                        <a href="{{ route('stocks.index') }}" class="btn btn-warning">Clear</a>
                    </div>
                </div>
            </form>

            @php
                $unit_18k = 0;
                $unit_21k = 0;
                $unit_22k = 0;
                $st = 0;
                $d18k = 0;
                $dia = 0;
            @endphp
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Stock List') }}</h4>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered">
    <thead>
        <tr>
            <th>DETAILS</th>
            <th>18K</th>
            <th>21K</th>
            <th>22K</th>
            <th>ST.</th>
            <th>D 18K</th>
            <th>DIA</th>
        </tr>
    </thead>
    <tbody>
        <tr>
    <tr>
    <td>BALANCE B/F</td>
    <td>{{ bd_money_format($balances['gold']['18']['bf']) }}</td>
    <td>{{ bd_money_format($balances['gold']['21']['bf']) }}</td>
    <td>{{ bd_money_format($balances['gold']['22']['bf']) }}</td>
    <td>{{ bd_money_format($balances['gold']['ST']['bf']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['D18k']['bf']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['DIA']['bf']) }}</td>
</tr>

<tr>
    <td>SALE</td>
    <td>{{ bd_money_format($balances['gold']['18']['sale_today']) }}</td>
    <td>{{ bd_money_format($balances['gold']['21']['sale_today']) }}</td>
    <td>{{ bd_money_format($balances['gold']['22']['sale_today']) }}</td>
    <td>{{ bd_money_format($balances['gold']['ST']['sale_today']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['D18k']['sale_today']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['DIA']['sale_today']) }}</td>
</tr>

<tr class="bold">
    <td>BALANCE</td>
    <td>{{ bd_money_format($balances['gold']['18']['balance']) }}</td>
    <td>{{ bd_money_format($balances['gold']['21']['balance']) }}</td>
    <td>{{ bd_money_format($balances['gold']['22']['balance']) }}</td>
    <td>{{ bd_money_format($balances['gold']['ST']['balance']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['D18k']['balance']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['DIA']['balance']) }}</td>
</tr>

@foreach(['NEW STOCK','EXCHANGE','OLD GOLD','S. RETURN'] as $type)
<tr>
    <td>{{ $type }}</td>
    <td>{{ bd_money_format($balances['gold']['18']['additions'][$type] ?? 0) }}</td>
    <td>{{ bd_money_format($balances['gold']['21']['additions'][$type] ?? 0) }}</td>
    <td>{{ bd_money_format($balances['gold']['22']['additions'][$type] ?? 0) }}</td>
    <td>{{ bd_money_format($balances['gold']['ST']['additions'][$type] ?? 0) }}</td>
    <td>{{ bd_money_format($balances['diamond']['D18k']['additions'][$type] ?? 0) }}</td>
    <td>{{ bd_money_format($balances['diamond']['DIA']['additions'][$type] ?? 0) }}</td>
</tr>
@endforeach

<tr class="bold">
    <td>CLOSING BALANCE</td>
    <td>{{ bd_money_format($balances['gold']['18']['closing']) }}</td>
    <td>{{ bd_money_format($balances['gold']['21']['closing']) }}</td>
    <td>{{ bd_money_format($balances['gold']['22']['closing']) }}</td>
    <td>{{ bd_money_format($balances['gold']['ST']['closing']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['D18k']['closing']) }}</td>
    <td>{{ bd_money_format($balances['diamond']['DIA']['closing']) }}</td>
</tr>


    </tbody>
</table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <x-datatable-js-css />

    @push('css')
        <style>
            .table-bordered {
                border: 1px solid #000000;
            }

            td {
                padding: 4px !important;
                color: #000;
            }

            .bold td {
                font-weight: 600;
            }
        </style>
    @endpush

    @push('js')
        <script>
            {{-- var table = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                ajax: "{{ route('stocks.index') }}",
                order: [
                    [1, "asc"]
                ],
                columns: [{
                        "data": "id",
                        bSortable: false
                    },
                    {
                        "data": "name"
                    },
                    @can('Edit Stock')
                        {
                            "data": "action",
                            defaultContent: "",
                            bSortable: false,
                            className: 'dt-body-right text-xs-align-left',
                            'render': function(data, type, row, meta) {
                                return '<a class="btn btn-sm btn-primary " \
                                            href="{{ route('stocks.index') }}/' + row.id + '"><i \
                                                    class="fa fa-fw fa-eye"></i> Show</a> \
                                        <a class="btn btn-sm btn-success" \
                                            href="{{ route('stocks.index') }}/' + row.id + '/edit"><i \
                                                    class="fa fa-fw fa-edit"></i> Edit</a> \
                                        <button type="button" data-route="{{ route('stocks.index') }}/' + row.id + '" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i \
                                                class="fa fa-fw fa-trash"></i> Delete \
                                        </button>';
                            }
                        },
                    @endcan
                ],
            }); --}}
        </script>
    @endpush
</x-admin-layout>
