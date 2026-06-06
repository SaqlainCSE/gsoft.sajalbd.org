<x-admin-layout :title="__('Jakat')">

    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <a href="#"
                                class="btn btn-soft-success waves-effect waves-light" onclick="window.print()">
                                {{ __('PRINT') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page card" orientation="portrait" size="A4" pages="1"
                style="padding-top: 20px;margin:0 auto;color: #000;">
                <table class="table-fw">
                    <thead>
                        <tr>
                            <td style="width: 33.33%;vertical-align: bottom;text-align:left">
                                <table style="width: 100%;">
                                    <tr>
                                        <td>
                                            @if ($client)
                                                <div style="font-size:10px;font-family: math; font-weight: bold;">CUSTOMER DETAILS:</div>
                                                <div style="font-size:10px;">{{ $client->name }}</div>
                                                <div style="font-size:10px;">{{ $client->address ?: '' }}</div>
                                                <div style="font-size:10px;">{{ $client->mobile_number }}</div>
                                            @endif
                                        </td>
                                        
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 33.33%;vertical-align: top;text-align:center">
                                <table style="width: 100%;">
                                    <tr>
                                        <td><span style="font-size:18px;font-family: math; font-weight: bold;">JAKAT CALCULATION</span></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 33.33%;vertical-align: bottom;text-align:right">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="font-size:12px;"></td>
                                        <td style="width: 100px;font-size:12px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:12px;">DATE :</td>
                                        <td style="width: 100px;font-size:12px;">
                                            {{ formatted_date($jakat->created_at) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:12px;">MEMO NO :</td>
                                        <td style="width: 100px;font-size:12px;">{{ $jakat->generate_id }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </thead>
                </table>

                <table class="table-fw table-border mb-3">
                    <thead>
                        <tr>
                            <td class="text-center"
                                style="width:52px;font-size:12px;font-weight: bold;font-family: math;">SL#
                            </td>
                            <td class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">
                                PRODUCT
                                NAME
                            </td>
                            <td class="text-center"
                                style="width:100px;font-size:12px;font-weight: bold;font-family: math;">
                                KARAT
                            </td>
                            <td class="text-center"
                                style="width:100px;font-size:12px;font-weight: bold;font-family: math;">
                                WT/GM</td>
                            <td class="text-center"
                                style="width:100px;font-size:12px;font-weight: bold;font-family: math;">
                                JAKAT (%)</td>
                            <td class="text-center"
                                style="width: 100px;font-size:12px;font-weight: bold;font-family: math;">
                                TOTAL JAKAT</td>
                        </tr>
                    </thead>
                    @php
                        $i = 1;
                        $totalWeight = 0;
                        $totalAmount = 0;
                    @endphp
                    <tbody id="selected_product_list">
                        @foreach ($jakat->data['product'] as $key => $item)
                            <tr>
                                <td class="text-center" style="font-size:12px;font-family: math;">{{ $i }}
                                </td>
                                <td style="font-size:12px;font-family: math;">
                                    {{ $categories[$item] }}
                                </td>
                                <td class="text-end" style="font-size:12px;font-family: math;">
                                    {{ $jakat->data['karat'][$key] }}
                                </td>
                                <td class="text-end numberonly" style="font-size:12px;font-family: math;">
                                    {{ $jakat->data['weight'][$key] }}
                                </td>
                                <td class="text-center" style="font-size:12px;font-family: math;">
                                    {{ $jakat->data['jakat_percentage'] }}
                                </td>
                                <td class="text-end total" style="font-size:12px;font-family: math;">
                                    {{ $jakat->data['jakat_amount'][$key] }}
                                </td>
                            </tr>
                            @php
                                $i++;
                                $totalWeight += $jakat->data['weight'][$key];
                                $totalAmount += $jakat->data['jakat_amount'][$key];
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            {{-- <td class="text-center" colspan="3"></td> --}}
                            <td class="text-end" colspan="3"
                                style="font-size:12px;font-weight: bold;font-family: math;">TOTAL
                            </td>
                            <td id="weightTotal" class="text-end" style="font-size:12px;font-family: math;"></td>
                            <td class="text-end" style="font-size:12px;font-family: math;"></td>
                            <td id="totalAmount" class="text-end" style="font-size:12px;font-family: math;">
                                {{ $totalAmount }}
                            </td>
                        </tr>

                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    @push('js')
        <script>
            let total = $('#totalAmount').html();
            $('#totalAmount').html(bd_money_format(parseFloat(total)));

            $(".total").each(function() {
                var row = $(this);
                $(row).html(bd_money_format(parseFloat($(row).html())));
            })
        </script>
    @endpush
    @push('css')
        <style>
            

            div.page {
                width: 210mm;
                box-sizing: border-box;
                overflow: hidden;
                padding: 1.4173228346em;
                /* page-break-after: always; */
                position: relative;
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
            

            @media print {
                div.page {
                    width: 210mm;
                    
                }

                div.page[size=A4] {
                    width: 210mm;
                }
                .page.card{
                    padding-top: 80px !important;
                }

                footer {
                    position: fixed;
                    bottom: 50px;
                    width: 194mm;
                }

                .card {
                    margin-bottom: 24px;
                    -webkit-box-shadow: none;
                    box-shadow: none;
                }

                .table-fw {
                    width: 90%;
                }
            }

        </style>
    @endpush
</x-admin-layout>
