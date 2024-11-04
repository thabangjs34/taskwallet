@extends($activeTemplate.'layouts.user.master')
@section('content')
<div class="body-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="body-area">
                <form action="{{route('user.withdraw.money')}}" method="post">
                    @csrf
                    <div class="form-body">
                        <div>
                            <h4>{{__($pageTitle)}}</h4>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form--label">@lang('Method')</label>
                                    <select class="form-select select" name="method_code" required>
                                        <option value="">@lang('Select Gateway')</option>
                                        @foreach($withdrawMethod as $data)
                                        <option value="{{ $data->id }}" data-resource="{{$data}}"> {{__($data->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form--label">@lang('Amount')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" name="amount" value="{{ old('amount') }}"
                                            class="form-control form--control" required>
                                        <span class="input-group-text">{{ $general->cur_text }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 preview-details d-none">
                                <span>@lang('Limit')</span>
                                <span><span class="min fw-bold">0</span> {{__($general->cur_text)}} - <span
                                        class="max fw-bold">0</span> {{__($general->cur_text)}} , </span>
                                <span>@lang('Charge')</span>
                                <span><span class="charge fw-bold">0</span> {{__($general->cur_text)}} ,</span>
                                <span>@lang('Payable')</span> <span><span class="payable fw-bold"> 0</span>
                                    {{__($general->cur_text)}} </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start my-4">
                            <button class="btn btn--base" type="submit">@lang('Withdraw')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    (function ($) {
        "use strict";

        $('select[name=method_code]').change(function () {
            if (!$('select[name=method_code]').val()) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            var resource = $('select[name=method_code] option:selected').data('resource');
            var fixed_charge = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);
            var rate = parseFloat(resource.rate)
            var toFixedDigit = 2;
            $('.min').text(parseFloat(resource.min_limit).toFixed(2));
            $('.max').text(parseFloat(resource.max_limit).toFixed(2));
            var amount = parseFloat($('input[name=amount]').val());
            if (!amount) {
                amount = 0;
            }
            if (amount <= 0) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            $('.preview-details').removeClass('d-none');

            var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
            $('.charge').text(charge);
            if (resource.currency != '{{ $general->cur_text }}') {
                var rateElement = `<span>@lang('Conversion Rate')</span> <span class="fw-bold">1 {{__($general->cur_text)}} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span>`;
                $('.rate-element').html(rateElement);
                $('.rate-element').removeClass('d-none');
                $('.in-site-cur').removeClass('d-none');
                $('.rate-element').addClass('d-flex');
                $('.in-site-cur').addClass('d-flex');
            } else {
                $('.rate-element').html('')
                $('.rate-element').addClass('d-none');
                $('.in-site-cur').addClass('d-none');
                $('.rate-element').removeClass('d-flex');
                $('.in-site-cur').removeClass('d-flex');
            }
            var receivable = parseFloat((parseFloat(amount) - parseFloat(charge))).toFixed(2);
            $('.receivable').text(receivable);
            var final_amo = parseFloat(parseFloat(receivable) * rate).toFixed(toFixedDigit);
            $('.final_amo').text(final_amo);
            $('.base-currency').text(resource.currency);
            $('.method_currency').text(resource.currency);
            $('input[name=amount]').on('input');
        });

        $('input[name=amount]').on('input', function () {
            var data = $('select[name=method_code]').change();
            $('.amount').text(parseFloat($(this).val()).toFixed(2));
        });

    })(jQuery);
</script>
@endpush
