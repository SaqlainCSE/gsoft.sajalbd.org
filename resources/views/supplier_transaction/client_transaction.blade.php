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
                                <li class="breadcrumb-item active">{{__('Transactions')}}</li>
                            </ol>
                        </div>

                        <div class="page-title-right" style="display: flex">
                            <a href="{{ route('client_due') }}/{{$client->id}}/print" class="btn btn-soft-success waves-effect waves-light" target="_blank">
                                {{ __('PRINT') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-3">

                    <div style="padding-top: 20px;margin:0 auto;color: #000;">
                        {{ Form::label('client', __('Client'), ['class' => 'col-form-label text-start']) }}
                        {{ Form::select('client', [$client->id => $client->name], $client->id, ['required' => true, 'id' => 'client', 'style' => 'width: 200px', 'placeholder' => 'Select client']) }}
                    </div>
                </div>
                <div class="col-9">
                    
                    <div class="page card" orientation="portrait" size="A4" pages="1" style="padding-top: 20px;margin:0 auto;color: #000; width: 100%">
                        
                        <table class="table-fw">
                            <thead>
                                <tr>
                                    <td style="width: 33.33%;vertical-align: bottom;text-align:left">
                                        <table style="width: 100%;">
                                            <tbody><tr>
                                                <td style="font-size:14px;"><span style="font-size:14px;font-family: math; font-weight: bold;">CUSTOMER
                                                        DETAILS:</span></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;">{{ $client->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;">{{ $client->address }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;">{{ $client->mobile_number }}</td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                    
                                </tr>
                            </thead>
                        </table>
        
                        <table class="table-fw table-border">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width:52px;font-size:12px;font-weight: bold;font-family: math;">SL:</td>
                                    <td class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">Date</td>
                                    <td class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">Memo No</td>
                                    <td class="text-center" style="width:100px;font-size:12px;font-weight: bold;font-family: math;">Bill</td>
                                    <td class="text-center" style="width:100px;font-size:12px;font-weight: bold;font-family: math;">Pay</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @if ($transactions)
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td class="text-center" style="width:52px;font-size:12px;font-family: math;">
                                                {{ $i }}
                                            </td>
                                            <td style="font-size:12px;font-family: math;">
                                                {{ formatted_date($transaction->created_at) }}
                                            </td>
                                            <td style="font-size:12px;font-family: math;">
                                                {{ $transaction->cash_memo_no }}
                                            </td>
                                            <td style="width:59px;font-size:12px;font-family: math;">{{ bd_money_format($transaction->bill_amount) }}</td>
                                            <td style="width:59px;font-size:12px;font-family: math;">{{ bd_money_format($transaction->payment_amount) }}</td>    
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                @endif
                                <tr>
                                    <td colspan="3" style="border: none"></td>
                                    <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Due:</td>
                                    <td style="width:59px;font-size:12px;font-family: math;font-weight: bold;">{{ bd_money_format($client->due_amount) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @push('css')
            <style>
                @font-face {
                    font-family: 'SutonnyMJ';
                    src: url('../assets/fonts/SutonnyMJ.woff2') format('woff2'),
                        url('../assets/fonts/SutonnyMJ.woff') format('woff');
                    font-weight: normal;
                    font-style: italic;
                    font-display: swap;
                }

                @font-face {
                    font-family: 'SutonnyMJ';
                    src: url('../assets/fonts/SutonnyMJ-Bold.woff2') format('woff2'),
                        url('../assets/fonts/SutonnyMJ-Bold.woff') format('woff');
                    font-weight: bold;
                    font-style: italic;
                    font-display: swap;
                }

                @font-face {
                    font-family: 'SutonnyMJ';
                    src: url('../assets/fonts/SutonnyMJ-BoldItalic.woff2') format('woff2'),
                        url('../assets/fonts/SutonnyMJ-BoldItalic.woff') format('woff');
                    font-weight: bold;
                    font-style: italic;
                    font-display: swap;
                }

                @font-face {
                    font-family: 'SutonnyMJ';
                    src: url('../assets/fonts/SutonnyMJ-Italic.woff2') format('woff2'),
                        url('../assets/fonts/SutonnyMJ-Italic.woff') format('woff');
                    font-weight: normal;
                    font-style: italic;
                    font-display: swap;
                }

                @font-face {
                    font-family: 'SutonnyOMJ';
                    src: url('../assets/fonts/SutonnyOMJ.woff2') format('woff2'),
                        url('../assets/fonts/SutonnyOMJ.woff') format('woff');
                    font-weight: normal;
                    font-style: normal;
                    font-display: swap;
                }

                div.page {
                    width: 210mm;
                    box-sizing: border-box;
                    overflow: hidden;
                    padding: 1.4173228346em;
                    /* page-break-after: always; */
                    position: relative;
                }



                @media print {
                    div.page {
                        width: 210mm;
                    }

                    div.page[orientation=landscape] {
                        width: 297mm;
                    }

                    div.page[size=A0] {
                        width: 841mm;
                    }

                    div.page[size=A0][orientation=landscape] {
                        width: 1189mm;
                    }

                    div.page[size=A1] {
                        width: 594mm;
                    }

                    div.page[size=A1][orientation=landscape] {
                        width: 841mm;
                    }

                    div.page[size=A2] {
                        width: 420mm;
                    }

                    div.page[size=A2][orientation=landscape] {
                        width: 594mm;
                    }

                    div.page[size=A3] {
                        width: 297mm;
                    }

                    div.page[size=A3][orientation=landscape] {
                        width: 420mm;
                    }

                    div.page[size=A4] {
                        width: 210mm;
                    }

                    div.page[size=A4][orientation=landscape] {
                        width: 297mm;
                    }

                    div.page[size=A5] {
                        width: 148mm;
                    }

                    div.page[size=A5][orientation=landscape] {
                        width: 210mm;
                    }

                    div.page[size=A6] {
                        width: 105mm;
                    }

                    div.page[size=A6][orientation=landscape] {
                        width: 148mm;
                    }

                    div.page[size=A7] {
                        width: 74mm;
                    }

                    div.page[size=A7][orientation=landscape] {
                        width: 105mm;
                    }

                    div.page[size=A8] {
                        width: 52mm;
                    }

                    div.page[size=A8][orientation=landscape] {
                        width: 74mm;
                    }

                    div.page[size=A9] {
                        width: 37mm;
                    }

                    div.page[size=A9][orientation=landscape] {
                        width: 52mm;
                    }

                    div.page[size=A10] {
                        width: 26mm;
                    }

                    div.page[size=A10][orientation=landscape] {
                        width: 37mm;
                    }

                    footer {
                        position: fixed;
                        bottom: 50px;
                        width: 194mm;
                    }
                }


                .table-fw {
                    width: 100%;
                }

                .text-end {
                    text-align: right;
                }

                .text-center {
                    text-align: center;
                }

                .table-border {
                    border-collapse: collapse !important;
                    border-spacing: 0;
                }

                .table-border td,
                .table-border th {
                    border: 1px solid #000;
                }

                @media screen {
                    .page {
                        background: radial-gradient(#d0d0d0, #909090) fixed;
                        font-family: 'SutonnyOMJ';
                        font-size: 20px;
                    }

                    div.page {
                        background: white;
                        margin: 1.4173228346em auto;
                    }
                }

                @page {
                    margin: 1.4173228346em;
                }
            </style>
        @endpush
        @push('js')
            <script>
                $('#client').select2({
                    placeholder: "Select client",
                    allowClear: true,
                    ajax: {
                        url: '{{ route('select2.client') }}',
                        dataType: 'json'
                    }
                });
                $('#client').on('change', function(){
                    window.location.href = "{{ route('client_due') }}/" + $(this).val();
                })
            </script>
        @endpush
</x-admin-layout>
