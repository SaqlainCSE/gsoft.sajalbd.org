<x-admin-layout :title="__('Sale List')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="{{ route('stocks.index') }}">{{ __('Stock') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Sale List') }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('stocks.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
                                <i class="fas fa-arrow-left align-middle me-2"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($stocksGrouped as $memo => $memoStocks)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white fw-bold">
                        <div>
                            Memo: {{ $memo }}
                            | Client: {{ optional($memoStocks->first()->client)->name ?? '' }}
                            | <b>Mobile:</b> {{ optional($memoStocks->first()->client)->mobile_number ?? '' }}
                            | Date: {{ optional($memoStocks->first())->date }}
                        </div>
                        <div>
                            <a href="{{ route('sale-list.edit', $memo) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                            </a>
                        </div>
                    </div>

                    {{-- Products Table --}}
                    <table class="table table-bordered mb-0">
                        <thead class="thead-success">
                            <tr>
                                <th>Token</th>
                                <th>Product</th>
                                <th>18K</th>
                                <th>21K</th>
                                <th>22K</th>
                                <th>ST</th>
                                <th>D18K</th>
                                <th>DIA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($memoStocks as $stock)
                            <tr>
                                <td>{{ $stock->token ?? '' }}</td>
                                <td>{{ $stock->product->product_details ?? '' }}</td>
                                <td>{{ $stock->unit_18k ?? 0 }}</td>
                                <td>{{ $stock->unit_21k ?? 0 }}</td>
                                <td>{{ $stock->unit_22k ?? 0 }}</td>
                                <td>{{ $stock->st ?? 0 }}</td>
                                <td>{{ $stock->d18k ?? 0 }}</td>
                                <td>{{ $stock->dia ?? 0 }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    {{-- Payment Table --}}
                    <table class="table table-bordered mt-3">
                        <tr class="thead-success">
                            <th>Bill</th>
                            <th>Discount</th>
                            <th>Advance</th>
                            <th>Final</th>
                            <th>Gold</th>
                            <th>Cash</th>
                            <th>DBBL</th>
                            <th>City QR</th>
                            <th>CBBL</th>
                        </tr>
                        @php $firstStock = $memoStocks->first(); @endphp
                        <tr>
                            <td>{{ $firstStock->payment->bill_amount ?? 0 }}</td>
                            <td>{{ $firstStock->payment->discount ?? 0 }}</td>
                            <td>{{ $firstStock->payment->advance ?? 0 }}</td>
                            <td>{{ $firstStock->payment->final_bill ?? 0 }}</td>
                            <td>{{ $firstStock->payment->gold ?? 0 }}</td>
                            <td>{{ $firstStock->payment->cash ?? 0 }}</td>
                            <td>{{ $firstStock->payment->dbbl ?? 0 }}</td>
                            <td>{{ $firstStock->payment->city_qr ?? 0 }}</td>
                            <td>{{ $firstStock->payment->cbbl ?? 0 }}</td>
                        </tr>
                    </table>
                </div>
            @endforeach

        </div>
    </div>
</x-admin-layout>
