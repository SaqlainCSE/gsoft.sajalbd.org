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
                                <li class="breadcrumb-item active">{{ __('Sale Edit') }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('stock.saleList') }}" class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
                                <i class="fas fa-arrow-left align-middle me-2"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('sale-list.update', $memo) }}" method="POST">
                @csrf

                <div class="card mb-3">
                    <div class="card-header bg-dark text-white fw-bold">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div>
                                <b>Memo:</b> {{ $memo }}
                            </div>

                            <div>
                                <b>Client:</b> {{ optional($stocks->first()->client)->name ?? '' }}
                            </div>

                            <div>
                                <b>Mobile:</b> {{ optional($stocks->first()->client)->mobile_number ?? '' }}
                            </div>

                            <div class="d-flex align-items-center">
                                <b class="me-2">Date:</b>
                                <input
                                    type="date"
                                    name="date"
                                    value="{{ old('date', optional($stocks->first())->date) }}"
                                    class="form-control form-control-sm"
                                    style="max-width: 160px;"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    {{-- Products Table --}}
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
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
                        <tbody class="repeatable">
                            @foreach($stocks as $stock)
                                <tr>
                                    <td>
                                        <input type="text" name="token[]" value="{{ $stock->token }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="product_nr[]" value="{{ $stock->product->product_details ?? '' }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="unit_18k[]" value="{{ $stock->unit_18k ?? 0 }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="unit_21k[]" value="{{ $stock->unit_21k ?? 0 }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="unit_22k[]" value="{{ $stock->unit_22k ?? 0 }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="st[]" value="{{ $stock->st ?? 0 }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="d18k[]" value="{{ $stock->d18k ?? 0 }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="dia[]" value="{{ $stock->dia ?? 0 }}" class="form-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Payment Table --}}
                    <table class="table table-bordered mt-3">
                        <tr class="thead-light">
                            <th>Bill</th><th>Discount</th><th>Advance</th><th>Final</th><th>Gold</th><th>Cash</th><th>DBBL</th><th>City QR</th><th>CBBL</th>
                        </tr>

                        @php $firstStock = $stocks->first(); @endphp
                        @if($firstStock && $firstStock->payment)
                            <tr>
                                <td><input type="text" name="bill_amount" value="{{ $firstStock->payment->bill_amount }}" class="form-control"></td>
                                <td><input type="text" name="discount" value="{{ $firstStock->payment->discount }}" class="form-control"></td>
                                <td><input type="text" name="advance" value="{{ $firstStock->payment->advance }}" class="form-control"></td>
                                <td><input type="text" name="final_bill" value="{{ $firstStock->payment->final_bill }}" class="form-control"></td>
                                <td><input type="text" name="gold" value="{{ $firstStock->payment->gold }}" class="form-control"></td>
                                <td><input type="text" name="cash" value="{{ $firstStock->payment->cash }}" class="form-control"></td>
                                <td><input type="text" name="dbbl" value="{{ $firstStock->payment->dbbl }}" class="form-control"></td>
                                <td><input type="text" name="city_qr" value="{{ $firstStock->payment->city_qr }}" class="form-control"></td>
                                <td><input type="text" name="cbbl" value="{{ $firstStock->payment->cbbl }}" class="form-control"></td>
                            </tr>
                        @endif
                    </table>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
