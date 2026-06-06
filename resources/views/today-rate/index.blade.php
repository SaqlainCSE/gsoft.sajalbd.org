<x-admin-layout :title="__('Today Rate')">
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
                                <li class="breadcrumb-item active">{{ __('Today Rate') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <a href="{{ route('today-rates.create') }}"
                                class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Add New') }}
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
                            <h4 class="card-title ">{{ __('Today Rate List') }}</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead">
                                    <tr>
                                        <th>Type</th>
                                        <th>Rate</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayRates as $todayRate)
                                        <tr>
                                            <td>{{ $todayRate->name }}</td>
                                            <td>{{ bd_money_format($todayRate->rate) }}</td>
                                            <td>
                                                @if ($todayRate->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                            </td>
                                            <td  class="text-end">
                                                <a class="btn btn-sm btn-success" 
                                                    href="{{ route('today-rates.edit', $todayRate->id) }}"><i 
                                                        class="fa fa-fw fa-edit"></i> </a> 
                                                <button type="button"
                                                    data-route="{{ route('today-rates.destroy', $todayRate->id) }}"
                                                    class="btn btn-danger btn-sm"
                                                    onClick="window.onClickDeleteHandeler(this)"><i 
                                                        class="fa fa-fw fa-trash"></i>  
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($todayRates) == 0)
                                        <tr>
                                            <td colspan="4" class="text-center">No record found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @push('js')
    @endpush
</x-admin-layout>
