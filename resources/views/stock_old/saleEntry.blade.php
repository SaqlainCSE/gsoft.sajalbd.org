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
                                <li class="breadcrumb-item active">{{ __('Sale Entry') }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right">
                            @can('Add Sale')
                                <a href="{{ route('stocks.create') }}?type=sale"
                                    class="btn btn-soft-info waves-effect waves-light text-uppercase">
                                    {{ __('Add Sale') }}
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
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('List') }}</h4>
                        </div>
                        <div class="card-body p-0">
                            <table id="datatable" class="mb-0 table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead" style="background: #ddd;color: #000;">
                                    <tr>
                                        <th>DATE</th>
                                        <th>MEMO</th>
                                        <th>TOKEN</th>
                                        <th>PRODUCT</th>
                                        <th>CUSTOMER</th>
                                        <th>18K</th>
                                        <th>21K</th>
                                        <th>22K</th>
                                        <th>ST.</th>
                                        <th>D 18K</th>
                                        <th>DIA</th>
                                        <th>BILL AMOUNT</th>
                                        <th>DISCOUNT</th>
                                        <th>ADVANCE</th>
                                        <th>FINAL BILL</th>
                                        <th>GOLD</th>
                                        <th>CASH</th>
                                        <th>DBBL</th>
                                        <th>CITY - QR</th>
                                        <th>CBBL</th>
                                        <th>DUE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stockBf as $key => $row)
                                        <tr>
                                            <td>BALACE B/F</td>
                                            <td>{{ bd_money_format($row->unit_18k ?: 0) }}</td>
                                            <td>{{ bd_money_format($row->unit_21k ?: 0)  }}</td>
                                            <td>{{ bd_money_format($row->unit_22k ?: 0) }}</td>
                                            <td>{{ bd_money_format($row->st ?: 0) }}</td>
                                            <td>{{ bd_money_format($row->d18k ?: 0) }}</td>
                                            <td>{{ bd_money_format($row->dia ?: 0) }}</td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot class="thead">
                                    <tr class="bold">
                                        {{-- <td>BALANCE</td>
                                        <td>{{ bd_money_format($unit_18k) }}</td>
                                        <td>{{ bd_money_format($unit_21k) }}</td>
                                        <td>{{ bd_money_format($unit_22k) }}</td>
                                        <td>{{ bd_money_format($st) }}</td>
                                        <td>{{ bd_money_format($d18k) }}</td>
                                        <td>{{ bd_money_format($dia) }}</td> --}}
                                    </tr>
                                </tfoot>
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
                color:#000;
            }
            .bold td{
                font-weight: 600;
            }
            td, th {
                font-size: 8px;
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
