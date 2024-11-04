@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.withdraw.method.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="payment-method-item">
                        <div class="row mt-4">
                            <div class="col-md-8 col-sm-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input type="text" class="form-control" name="name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>@lang('Currency')</label>
                                            <div class="input-group">
                                                <input type="text" name="currency" class="form-control border-radius-5"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>@lang('Dollar Rate')</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg--primary">1 {{ __($general->cur_text)
                                                    }}
                                                    =
                                                </span>
                                                <input type="text" class="form-control" name="rate" required />
                                                <span class="currency_symbol input-group-text bg--primary"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card border mb-2">
                                            <h5 class="card-header">@lang('Withdrawal Limit')</h5>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>@lang('Min')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="min_limit"
                                                            required />
                                                        <span class="input-group-text bg--primary"> {{
                                                            __($general->cur_text) }} </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('Max')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="max_limit"
                                                            required />
                                                        <span class="input-group-text bg--primary"> {{
                                                            __($general->cur_text) }} </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card border">
                                            <h5 class="card-header">@lang('Transaction Charge')</h5>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>@lang('Fixed')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="fixed_charge"
                                                            required />
                                                        <span class="input-group-text bg--primary"> {{
                                                            __($general->cur_text) }} </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('Percentage')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="percent_charge"
                                                            required>
                                                        <span class="input-group-text bg--primary">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="card border my-2">
                                    <h5 class="card-header">@lang('Special Instructions') </h5>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea rows="3" class="form-control trumEdit border-radius-5"
                                                name="instruction"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-method-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border mt-3">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5>@lang('User Input Fields')</h5>
                                            <button type="button"
                                                class="btn btn-sm bg--primary float-end form-generate-btn"> <i
                                                    class="la la-fw la-plus"></i>@lang('Add New')</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row addedField">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                </div>
            </form>
        </div><!-- card end -->
    </div>
</div>

<x-form-generator></x-form-generator>
@endsection
@push('style')
<style>
    .trumbowyg-box,
    .trumbowyg-editor {
        min-height: 239px !important;
        height: 239px;
    }
</style>
@endpush
@push('script')
<script>
    "use strict"
    var formGenerator = new FormGenerator();
</script>

<script src="{{ asset('assets/common/js/form_actions.js') }}"></script>
@endpush


@push('breadcrumb-plugins')
<a href="{{ route('admin.withdraw.method.index') }}" class="btn btn-sm btn--primary">
    <i class="la la-undo"></i> @lang('Back')
</a>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('input[name=currency]').on('input', function () {
            $('.currency_symbol').text($(this).val());
        });
        $('.addUserData').on('click', function () {
            var html = `
                    <div class="col-md-12 user-data">
                        <div class="form-group">
                            <div class="input-group mb-md-0 mb-4">
                                <div class="col-md-4">
                                    <input name="field_name[]" class="form-control" type="text" required>
                                </div>
                                <div class="col-md-3 mt-md-0 mt-2">
                                    <select name="type[]" class="form-control" required>
                                        <option value="text" > @lang('Input Text') </option>
                                        <option value="textarea" > @lang('Textarea') </option>
                                        <option value="file"> @lang('File') </option>
                                    </select>
                                </div>
                                <div class="col-md-3 mt-md-0 mt-2">
                                    <select name="validation[]"
                                            class="form-control" required>
                                        <option value="required"> @lang('Required') </option>
                                        <option value="nullable">  @lang('Optional') </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-md-0 mt-2 text-end">
                                    <span class="input-group-btn">
                                        <button class="btn btn--danger btn-lg removeBtn 5w-100" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $('.addedField').append(html);
        });

        $(document).on('click', '.removeBtn', function () {
            $(this).closest('.user-data').remove();
        });
        @if (old('currency'))
            $('input[name=currency]').trigger('input');
        @endif
    })(jQuery);

</script>
@endpush