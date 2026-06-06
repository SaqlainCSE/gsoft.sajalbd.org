<x-admin-layout :title="__('Trx Head')">
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
                                <li class="breadcrumb-item active">{{__('Trx Head')}}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                           <a href="{{ route('trx-heads.create') }}" class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Add Trx Head') }}
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
                            <h4 class="card-title ">{{__('Trx Head List')}}</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead">
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Parent</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
            var table = $('#datatable').DataTable( {
                "processing": true,
                "serverSide": true,
                //ajax: "{{ route('trx-heads.index') }}",
                
                ajax: {
                    url: "{{ route('trx-heads.index') }}",
                    data: buildSearchData
                },
                
                order: [[ 1, "asc" ]],
                columns: [
                    { "data": "no", bSortable: false},
                    { "data": "name"},
                    { "data": "type"},
                    { "data": "code"},
                    { "data": "description"},
                    { "data": "is_active"},
                    
                    { "data": "action",
                        defaultContent: "",
                        bSortable: false,
                        className: 'dt-body-right text-xs-align-left',
                        'render': function ( data, type, row, meta ) {
                            let actions='';
                            @can('Edit TrxHead')
                            actions += '<a class="btn btn-sm btn-success" \
                                    href="{{ route('trx-heads.index') }}/'+row.id+'/edit"><i \
                                            class="fa fa-fw fa-edit"></i></a>\
                                <button type="button" data-route="{{ route('trx-heads.index') }}/'+row.id+'" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i \
                                        class="fa fa-fw fa-trash"></i>\
                                </button>';
                            @endcan
                            return actions;
                        } 
                    },
                    
                ],
            } );
        </script>
    @endpush
</x-admin-layout>
