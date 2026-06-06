<x-admin-layout :title="__('Edit Gold Buy Sale')">
    <div class="container-fluid">
        <div class="page-content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('gold-buy-sale') }}">{{ __('Gold Buy Sale') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Edit') }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right">
                            <a href="{{ route('gold-buy-sale') }}" class="btn btn-outline-primary waves-effect waves-light">
                                <i class="fas fa-arrow-left align-middle me-2"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('update-gold-buy-sale', $goldBuySale->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="date" class="form-label">{{ __('Date') }}</label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ $goldBuySale->date }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="purchase_memo" class="form-label">{{ __('Purchase Memo') }}<span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control" id="purchase_memo" name="purchase_memo" value="{{ $goldBuySale->purchase_memo }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="cash_memo" class="form-label">{{ __('Cash Memo') }}</label>
                                        <input type="text" class="form-control" id="cash_memo" name="cash_memo" value="{{ $goldBuySale->cash_memo }}">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="exchange_gold_amount" class="form-label">{{ __('Exchange Gold Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="exchange_gold_amount" name="exchange_gold_amount" value="{{ $goldBuySale->exchange_gold_amount }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="exchange_gold_weight" class="form-label">{{ __('Exchange Gold Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="exchange_gold_weight" name="exchange_gold_weight" value="{{ $goldBuySale->exchange_gold_weight }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="exchange_gold_carat" class="form-label">{{ __('Exchange Gold Carat') }}</label>
                                        <select class="form-select" id="exchange_gold_carat" name="exchange_gold_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ $goldBuySale->exchange_gold_carat == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ $goldBuySale->exchange_gold_carat == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ $goldBuySale->exchange_gold_carat == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ $goldBuySale->exchange_gold_carat == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ $goldBuySale->exchange_gold_carat == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ $goldBuySale->exchange_gold_carat == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="customer_gold_amount" class="form-label">{{ __('Customer Gold Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="customer_gold_amount" name="customer_gold_amount" value="{{ $goldBuySale->customer_gold_amount }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="customer_gold_weight" class="form-label">{{ __('Customer Gold Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="customer_gold_weight" name="customer_gold_weight" value="{{ $goldBuySale->customer_gold_weight }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="customer_gold_carat" class="form-label">{{ __('Customer Gold Carat') }}</label>
                                        <select class="form-select" id="customer_gold_carat" name="customer_gold_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ $goldBuySale->customer_gold_carat == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ $goldBuySale->customer_gold_carat == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ $goldBuySale->customer_gold_carat == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ $goldBuySale->customer_gold_carat == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ $goldBuySale->customer_gold_carat == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ $goldBuySale->customer_gold_carat == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="senco_amount" class="form-label">{{ __('Senco Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="senco_amount" name="senco_amount" value="{{ $goldBuySale->senco_amount }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="senco_weight" class="form-label">{{ __('Senco Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="senco_weight" name="senco_weight" value="{{ $goldBuySale->senco_weight }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="senco_carat" class="form-label">{{ __('Senco Carat') }}</label>
                                        <select class="form-select" id="senco_carat" name="senco_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ $goldBuySale->senco_carat == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ $goldBuySale->senco_carat == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ $goldBuySale->senco_carat == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ $goldBuySale->senco_carat == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ $goldBuySale->senco_carat == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ $goldBuySale->senco_carat == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="sales_return_amount" class="form-label">{{ __('Sales Return Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="sales_return_amount" name="sales_return_amount" value="{{ $goldBuySale->sales_return_amount }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sales_return_weight" class="form-label">{{ __('Sales Return Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="sales_return_weight" name="sales_return_weight" value="{{ $goldBuySale->sales_return_weight }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sales_return_carat" class="form-label">{{ __('Sales Return Carat') }}</label>
                                        <select class="form-select" id="sales_return_carat" name="sales_return_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ $goldBuySale->sales_return_carat == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ $goldBuySale->sales_return_carat == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ $goldBuySale->sales_return_carat == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ $goldBuySale->sales_return_carat == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ $goldBuySale->sales_return_carat == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ $goldBuySale->sales_return_carat == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <!--<div class="col-md-4 mb-3">-->
                                    <!--    <label for="total_amount" class="form-label">{{ __('Total Amount') }}</label>-->
                                    <!--    <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ $goldBuySale->total_amount }}">-->
                                    <!--</div>-->
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="total_amount" class="form-label">{{ __('Total Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ $goldBuySale->total_amount }}" readonly>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="remarks" class="form-label">{{ __('Remarks') }}</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ $goldBuySale->remarks }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<script>
    function calculateTotal() {
        let fields = [
            'exchange_gold_amount',
            'customer_gold_amount',
            'senco_amount',
            'sales_return_amount'
        ];

        let total = 0;

        fields.forEach(function(field) {
            let element = document.getElementById(field);
            if (element) {
                let value = parseFloat(element.value);
                if (!isNaN(value)) {
                    total += value;
                }
            }
        });

        document.getElementById('total_amount').value = total.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function () {
        let fields = [
            'exchange_gold_amount',
            'customer_gold_amount',
            'senco_amount',
            'sales_return_amount'
        ];

        fields.forEach(function(field) {
            let element = document.getElementById(field);
            if (element) {
                element.addEventListener('input', calculateTotal);
            }
        });

        calculateTotal();
    });
</script>

