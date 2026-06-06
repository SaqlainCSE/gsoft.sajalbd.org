<x-admin-layout :title="__('Report')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Expense Report') }}</h4>
                        </div>
                        <div class="card-body p-0">
                            <form id="reportForm" method="GET" action="{{ route('expenses-report.data') }}" role="form"
                                enctype="multipart/form-data" target="_blank">
                                <div class="row p-2">
                                    <div class="form-group col-sm-3">
                                        <div id="reportrange" class="form-control"
                                            style="background: #fff; cursor: pointer; padding: 8px 10px; border: 1px solid #ccc; width: 100%">
                                            <span></span> <i class="fa fa-calendar"
                                                style="float: right;margin-top: 1px;color: #adb5bd;font-size: 17px;"></i>
                                        </div>
                                        {!! Form::hidden('start_date', '', ['id' => 'start_date']) !!}
                                        {!! Form::hidden('end_date', '', ['id' => 'end_date']) !!}
                                    </div>
                                    <div class="form-group col-sm-2">
                                        {!! Form::select('transaction_code_id', $transactionCodes, null, [
                                            'id' => 'transaction_code_id',
                                            'class' => 'select2 form-control' . ($errors->has('transaction_code_id') ? ' is-invalid' : ''),
                                            'placeholder' => 'Select parent head',
                                        ]) !!}
                                    </div>
                                    <div class="form-group col-sm-2">
                                        {!! Form::select('trx_head_id', $heads, null, [
                                            'id' => 'trx_head_id',
                                            'class' => 'select2 form-control' . ($errors->has('trx_head_id') ? ' is-invalid' : ''),
                                            'placeholder' => 'Select Expense Type',
                                        ]) !!}
                                    </div>
                                    <div class="form-group col-sm-2">
                                        {!! Form::select('expense_by_id', $users, null, [
                                            'id' => 'expense_by_id',
                                            'class' => 'select2 form-control' . ($errors->has('expense_by_id') ? ' is-invalid' : ''),
                                            'placeholder' => 'Select Expense By',
                                        ]) !!}
                                    </div>
                                    <div class="form-group col-sm-2">
                                        {!! Form::select('payment_method_id', $payment_methods, null, [
                                            'id' => 'payment_method_id',
                                            'class' => 'select2 form-control' . ($errors->has('payment_method_id') ? ' is-invalid' : ''),
                                            'placeholder' => 'Select Payment Method',
                                        ]) !!}
                                    </div>
                                    <div class="form-group col-sm-3 mt-2">
                                        <button type="button" class="btn btn-info search-button"
                                            style="width: 50px; background: transparent; color:black;" name="format"
                                            value="json"><i class="fas fa-search fa-lg"></i></button>

                                        <button type="submit" class="btn btn-success"
                                            style="width: 50px; background: transparent; color:black;" name="format"
                                            value="csv"><i class="fas fa-file-csv fa-lg"></i></button>

                                        <button type="submit" class="btn btn-primary"
                                            style="width: 50px; background: transparent; color:black;" name="format"
                                            value="pdf"><i class="fas fa-file-pdf fa-lg"></i></button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-bordered table-striped">
                                    <thead style="position: sticky; top: 0; background-color: white;">
                                        <tr>
                                            <th>SL</th>
                                            <th>Date</th>
                                            <th>Head</th>
                                            <th>Payment Method</th>
                                            <th>Reference</th>
                                            <th>Expense By</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportTableBody">
                                        <!-- Data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->

        <div class="toast overflow-hidden position-absolute top-0 end-0" role="alert" aria-live="assertive"
            aria-atomic="true" style="z-index: 11;margin-top:70px;">
            <div class="align-items-center text-white bg-warning border-0">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
    @push('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('daterangepicker/daterangepicker.css') }}" />
        <style>
            .table-responsive td {
                font-size: 12px;
                color: #000 !important;
                padding: 4px !important;
            }

            td.text-center.big {
                font-size: 14px;
                padding: 15px !important;
            }
        </style>
    @endpush
    @push('js')
        <script type="text/javascript" src="{{ asset('daterangepicker/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('daterangepicker/daterangepicker.js') }}"></script>

        <script>
            function setPageParams(param, value) {
                var url = new URL(window.location.href);
                url.searchParams.set(param, value); // setting your param
                var newUrl = url.href;
                window.history.pushState({}, '', newUrl);
            }

            $(document).ready(function() {
                // Initially display the message
                $('#reportTableBody').html(
                    '<tr><td colspan="9" class="text-center big">Please select filters and search.</td></tr>');

                $('.search-button').on('click', function(e) {
                    e.preventDefault();

                    // Show loading animation
                    var formData = $('#reportForm').serialize();

                    $.ajax({
                        url: "{{ route('expenses-report.data') }}",
                        type: "GET",
                        data: formData + '&format=json',
                        dataType: 'json',
                        success: function(resp) {
                            var html = '';
                            if (resp?.data.length > 0) {
                                var totalAmount = 0;
                                console.log(resp?.data);
                                $.each(resp?.data, function(index, item) {
                                    html += '<tr>';
                                    html += '<td style="padding-left: 15px !important;">' + (index + 1) + '</td>';
                                    html += '<td>' + item.date + '</td>';
                                    html += '<td>' + item?.trx_head + '</td>';
                                    html += '<td>' + item?.payment_method + '</td>';
                                    html += '<td>' + item?.reference_no + '</td>';
                                    html += '<td>' + item?.expense_by + '</td>';
                                    html += '<td>{{ getCurrencySymbol() }} ' + item?.amount + '</td>';
                                    html += '</tr>';
                                    totalAmount += parseFloat(item?.raw_amount);
                                });
                                html += '<tr>';
                                html +=
                                    '<td colspan="6" class="text-end"><strong>Total</strong></td>';
                                html += '<td><strong>{{ getCurrencySymbol() }} ' + bd_money_format(
                                    totalAmount) + '</strong></td>';
                                html += '</tr>';
                            } else {
                                html =
                                    '<tr><td colspan="7" class="text-center big">No data found.</td></tr>';
                            }

                            $('#reportTableBody').html(html);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX request failed:", status, error);
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessage = '';
                                $.each(errors, function(key, value) {
                                    errorMessage += value[0] + '<br>';
                                });
                                // Show error message in Bootstrap toast
                                $('.toast-body').html(errorMessage);
                                $('.toast').toast('show');
                            } else {
                                $('.toast-body').html('An error occurred while fetching data.');
                                $('.toast').toast('show');
                            }
                            $('#reportTableBody').html(
                                '<tr><td colspan="6" class="text-center big">Please select filters and search.</td></tr>'
                            );
                        }
                    });
                });
            });


            $(function() {
                var start = moment().subtract(29, 'days');
                var end = moment();

                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));

                    $("#start_date").val(start.format('YYYY-M-D'));
                    $("#end_date").val(end.format('YYYY-M-D'));

                }

                $('#reportrange').daterangepicker({
                    opens: 'left',
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    }
                }, cb);

                cb(start, end);

            });
        </script>
    @endpush
</x-admin-layout>
