<x-admin-layout :title="__('Transaction')">
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
                                <li class="breadcrumb-item active">{{__('Supplier Transactions')}}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                           <a href="{{ route('supplier_transactions.create') }}" class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Add Transaction') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{__('Transaction List')}}</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead">
                                <tr>
                                    <th>SL:</th>
                                    <th>Date</th>
                                    <th>Ref.</th>
                                    <th>Supplier Name</th>
                                    <th>Phone</th>
                                    <th>Description</th>
                                    <th>Bill</th>
                                    <th>Pay</th>
                                    {{-- <th>Advanced</th> --}}
                                    @canany(['Edit Supplier Transaction','Delete Supplier Transaction'])
                                        <th>Action</th>    
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <x-datatable-js-css/>
    @push('js')
        <script>
            function buildSearchData(object) {
                if (object.start > 0) {
                    object.page = (object.start / object.length) + 1;
                }
                return object;
            }
            var table = $('#datatable').DataTable( {
                "processing": true,
                "serverSide": true,
                ajax:{ 
                    url: "{{ route('supplier_transactions.index') }}",
                    data: buildSearchData
                },
                "pageLength": 25,
                order: [[ 1, "asc" ]],
                columns: [
                    { "data": "no", bSortable: false},
                    { "data": "date"},
                    { "data": "reference_no"},
                    { "data": "name"},
                    { "data": "mobile_number"},
                    { "data": "description"},
                    { "data": "bill_amount", class: 'text-end'},
                    { "data": "payment_amount", class: 'text-end'},
                    // { "data": "advanced", class: 'text-end'},
                    @canany(['Edit Supplier Transaction', 'Delete Supplier Transaction'])
                    {
                        data: 'no',
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            var html = "";
                            @can('Edit Due Transaction')
                                html += " <a href='{{ route('supplier_transactions.index') }}/" + row.id + "/edit' class='btn-sm'><i class='fa fa-pen'></i></a>"; 
                            @endcan
                            @can('Delete Due Transaction')
                                html += `<span role="button" data-route="{{ route('supplier_transactions.index') }}/` + row.id + `" class="text-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i class="fa fa-fw fa-trash"></i></span>`; 
                            @endcan
                            return html;
                        }
                    }  
                    @endcanany
                ],
            } );
        </script>
    @endpush

    <style>
        td {
            font-size: 12px;
            padding: 4px 3px !important;
            color: #000 !important;
            font-family: math;
        }
    </style>
</x-admin-layout>
