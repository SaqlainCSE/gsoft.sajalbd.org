<x-admin-layout :title="__('Terms & Condition')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ __('Terms & Condition') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Terms & Condition') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('booking_tc.index') }}"  role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12 mb-4">
                                    {!! Form::textarea('description', setting('booking_terms'), ['id'=>'template', 'required' => true, 'class' => 'form-control', 'placeholder' => 'Terms & Condition']) !!}
                                </div>
                                <div class="col-12">
                                    <div class="box-footer mt20 text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @push('js')
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        <script>
            CKEDITOR.editorConfig = function( config ) {};
            CKEDITOR.replace( 'template', {
                allowedContent: true,
                fullPage : true,
                height: 400,
                toolbar : 'full',
            });
        </script>
    @endpush
</x-admin-layout>
