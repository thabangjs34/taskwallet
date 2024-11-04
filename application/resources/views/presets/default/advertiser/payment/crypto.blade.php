@extends($activeTemplate.'layouts.advertiser.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="body-area">
                    <h5>@lang('Payment Preview')</h5>
                    <div class="text-center">
                        <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                        <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                        <img src="{{$data->img}}" alt="@lang('Image')">
                        <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
