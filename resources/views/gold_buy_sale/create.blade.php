<x-admin-layout :title="__('Create Gold Buy Sale')">
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
                                <li class="breadcrumb-item"><a href="{{ route('gold-buy-sale') }}">{{ __('Gold Buy Sale') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Create') }}</li>
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
                            <form action="{{ route('store-gold-buy-sale') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="date" class="form-label">{{ __('Date') }}</label>
                                        <input type="date" class="form-control" id="date" name="date" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="purchase_memo" class="form-label">{{ __('Purchase Memo') }}<span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control" id="purchase_memo" name="purchase_memo" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="cash_memo" class="form-label">{{ __('Cash Memo') }}</label>
                                        <input type="text" class="form-control" id="cash_memo" name="cash_memo">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="exchange_gold_amount" class="form-label">{{ __('Exchange Gold Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="exchange_gold_amount" name="exchange_gold_amount" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="exchange_gold_weight" class="form-label">{{ __('Exchange Gold Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="exchange_gold_weight" name="exchange_gold_weight" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="exchange_gold_carat" class="form-label">{{ __('Exchange Gold Carat') }}</label>
                                        <select class="form-select" id="exchange_gold_carat" name="exchange_gold_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ old('exchange_gold_carat') == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ old('exchange_gold_carat') == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ old('exchange_gold_carat') == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ old('exchange_gold_carat') == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ old('exchange_gold_carat') == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ old('exchange_gold_carat') == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="customer_gold_amount" class="form-label">{{ __('Customer Gold Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="customer_gold_amount" name="customer_gold_amount">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="customer_gold_weight" class="form-label">{{ __('Customer Gold Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="customer_gold_weight" name="customer_gold_weight" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="customer_gold_carat" class="form-label">{{ __('Customer Gold Carat') }}</label>
                                        <select class="form-select" id="customer_gold_carat" name="customer_gold_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ old('customer_gold_carat') == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ old('customer_gold_carat') == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ old('customer_gold_carat') == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ old('customer_gold_carat') == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ old('customer_gold_carat') == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ old('customer_gold_carat') == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="senco_amount" class="form-label">{{ __('Senco Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="senco_amount" name="senco_amount">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="senco_weight" class="form-label">{{ __('Senco Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="senco_weight" name="senco_weight" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="senco_carat" class="form-label">{{ __('Senco Carat') }}</label>
                                        <select class="form-select" id="senco_carat" name="senco_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ old('senco_carat') == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ old('senco_carat') == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ old('senco_carat') == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ old('senco_carat') == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ old('senco_carat') == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ old('senco_carat') == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="sales_return_amount" class="form-label">{{ __('Sales Return Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="sales_return_amount" name="sales_return_amount">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sales_return_weight" class="form-label">{{ __('Sales Return Weight') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="sales_return_weight" name="sales_return_weight" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sales_return_carat" class="form-label">{{ __('Sales Return Carat') }}</label>
                                        <select class="form-select" id="sales_return_carat" name="sales_return_carat">
                                            <option value="" disabled selected>{{ __('Select Carat') }}</option>
                                            <option value="18K" {{ old('sales_return_carat') == '18K' ? 'selected' : '' }}>18K</option>
                                            <option value="21K" {{ old('sales_return_carat') == '21K' ? 'selected' : '' }}>21K</option>
                                            <option value="22K" {{ old('sales_return_carat') == '22K' ? 'selected' : '' }}>22K</option>
                                            <option value="24K" {{ old('sales_return_carat') == '24K' ? 'selected' : '' }}>24K</option>
                                            <option value="mixing" {{ old('sales_return_carat') == 'mixing' ? 'selected' : '' }}>Mixing</option>
                                            <option value="sanatan" {{ old('sales_return_carat') == 'sanatan' ? 'selected' : '' }}>Sanatan</option>
                                        </select>
                                    </div>

                                    <!--<div class="col-md-4 mb-3">-->
                                    <!--    <label for="total_amount" class="form-label">{{ __('Total Amount') }}</label>-->
                                    <!--    <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount">-->
                                    <!--</div>-->
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="total_amount" class="form-label">{{ __('Total Amount') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" readonly>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="remarks" class="form-label">{{ __('Remarks') }}</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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
            let value = parseFloat(document.getElementById(field).value);
            if (!isNaN(value)) {
                total += value;
            }
        });

        document.getElementById('total_amount').value = total.toFixed(2);
    }

    // Add event listener to each amount field
    document.addEventListener("DOMContentLoaded", function () {
        let fields = [
            'exchange_gold_amount',
            'customer_gold_amount',
            'senco_amount',
            'sales_return_amount'
        ];

        fields.forEach(function(field) {
            document.getElementById(field).addEventListener('input', calculateTotal);
        });
    });
</script>
