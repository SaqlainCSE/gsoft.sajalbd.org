<div class="row">
    <div class="col-12 col-md-8">
        <div class="mb-3 row">
            {{ Form::label('mobile_number', __('Mobile Number'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('mobile_number', $client->mobile_number, ['class' => 'form-control' . ($errors->has('mobile_number') ? ' is-invalid' : ''), 'placeholder' => 'Mobile Number']) }}
                {!! $errors->first('mobile_number', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('name', __('Name'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('name', $client->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('fb_name', __('FB name'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('fb_name', $client->fb_name, ['class' => 'form-control' . ($errors->has('fb_name') ? ' is-invalid' : ''), 'placeholder' => 'FB Name']) }}
                {!! $errors->first('fb_name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('customer_category_id', __('Customer Category'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select('customer_category_id', $categories, $client->customer_category_id, ['rows' => '2', 'class' => 'select2 form-control' . ($errors->has('customer_category_id') ? ' is-invalid' : ''), 'placeholder' => 'Customer Category']) }}
                {!! $errors->first('customer_category_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('district_id', __('District'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select('district_id', $districts, $client->district_id, ['id' => 'district_id', 'class' => 'select2 form-control' . ($errors->has('district_id') ? ' is-invalid' : ''), 'placeholder' => 'Customer Category']) }}
                {!! $errors->first('district_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('zone_id', __('Zone'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select('zone_id', $zones, $client->zone_id, ['id' => 'zone_id', 'class' => 'select2 form-control' . ($errors->has('zone_id') ? ' is-invalid' : '')]) }}
                {!! $errors->first('zone_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('address', __('Address'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::textarea('address', $client->address, ['rows' => '2', 'class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'placeholder' => 'Address']) }}
                {!! $errors->first('address', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('picture', __('Picture'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::file('picture', ['class' => 'form-control' . ($errors->has('picture') ? ' is-invalid' : '')]) }}
                {!! $errors->first('picture', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
        </div>
    </div>
</div>
@push('js')
    <script>
        var district_id = "{{ $client->district_id }}";

        $("#district_id").on('change', function(e) {
            district_id = $(this).val();
            $("#zone_id").empty().trigger('change');
        });

        $('#zone_id').select2({
            placeholder: "Select Zone",
            allowClear: true,
            ajax: {
                url: '{{ route('select2.zone') }}',
                dataType: 'json',
                district_id: district_id,
                data: function(params) {
                    console.log(params)
                    params.district_id = district_id;
                    return params;
                },
            },

        });

        $("#mobile_number").on('focusout', function() {
            var self = $(this);
            if ($(this).val().length > 3) {
                $.ajax({
                        url: "{{ route('check_client_mobile_number') }}/",
                        data: {
                            mobile: self.val()
                        }
                    })
                    .done(function(response) {
                        self.removeClass('parsley-error');
                        self.removeClass('is-invalid');
                        $("#usernameNotice .invalid-feedback").remove();
                        $("#saveBtn").attr('disabled', false);
                    })
                    .fail(function() {
                        self.addClass('parsley-error');
                        $("#usernameNotice .invalid-feedback").remove();
                        $("#usernameNotice").append('<div class="invalid-feedback d-block">Username is already taken!</div>')
                        $("#saveBtn").attr('disabled', true);
                    })
                    .always(function() {
                        console.log("complete");
                    });
            } else {
                self.addClass('parsley-error');
            }
        });
    </script>
@endpush
@push('css')
    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-right: 50px;
        }
    </style>
@endpush
