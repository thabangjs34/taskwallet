@extends($activeTemplate.'layouts.frontend')
@section('content')
<section>
    <div class="container">
        <div class="document-header d-flex flex-wrap justify-content-between align-items-center mb-2">
            <div class="logo"><a href="{{ route('home') }}"><img src="{{ getImage('assets/images/general/logo.png') }}"
                        alt=""></a></div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="{{route('home')}}" class="nav-link">@lang('Home')</a>
                        </li>

                        @php
                        $pages = App\Models\Page::where('tempname',$activeTemplate)->where('is_default',0)->get();
                        @endphp
                        @foreach($pages as $k => $data)
                        <li class="nav-item"><a href="{{route('pages',[$data->slug])}}"
                                class="nav-link">{{__($data->name)}}</a></li>
                        @endforeach



                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">@lang('contact')</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">@lang('login')</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.register') }}">@lang('register')</a>
                        </li>
                        @endguest

                        @auth

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{
                                auth()->user()->fullname }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.logout') }}">
                                    @lang('Logout')
                                </a>
                            </div>
                        </li>
                        @endauth


                        {{-- Enable below code when you are using language and remove this comment --}}
                        {{-- <select class="langSel form-control ">
                            <option value="">@lang('Select One')</option>
                            @foreach($language as $item)
                            <option value="{{$item->code}}" @if(session('lang')==$item->code) selected @endif>{{
                                __($item->name) }}</option>
                            @endforeach
                        </select> --}}


                    </ul>
                </div>
            </nav>
        </div>

        <div class="document-wrapper">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="document-item d-flex flex-wrap">
                        <div class="document-item__icon">
                            <i class="lab la-readme"></i>
                        </div>
                        <div class="document-item__content">
                            <h4 class="title"><a href="#0" class="text-underline">Section Manager</a></h4>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta incidunt quod ipsa neque
                                consequatur aspernatur earum quos est, totam cumque!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="document-item d-flex flex-wrap">
                        <div class="document-item__icon">
                            <i class="lab la-readme"></i>
                        </div>
                        <div class="document-item__content">
                            <h4 class="title"><a href="#0" class="text-underline">Payment Gateway</a></h4>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta incidunt quod ipsa neque
                                consequatur aspernatur earum quos est, totam cumque!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="document-item d-flex flex-wrap">
                        <div class="document-item__icon">
                            <i class="lab la-readme"></i>
                        </div>
                        <div class="document-item__content">
                            <h4 class="title"><a href="#0" class="text-underline">Smart Code</a></h4>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta incidunt quod ipsa neque
                                consequatur aspernatur earum quos est, totam cumque!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="document-item d-flex flex-wrap">
                        <div class="document-item__icon">
                            <i class="lab la-readme"></i>
                        </div>
                        <div class="document-item__content">
                            <h4 class="title"><a href="#0" class="text-underline">Smart UI/UX</a></h4>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta incidunt quod ipsa neque
                                consequatur aspernatur earum quos est, totam cumque!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="document-footer d-flex flex-wrap justify-content-between align-items-center mt-4">
            <ul class="d-flex flex-wrap share-links">
                <li><a href="http://wstacks.com/" target="_blank"><i class="las la-globe"></i> @lang('WStacks')</a></li>
            </ul>
        </div>
    </div>
</section>

@if($sections->secs != null)
@foreach(json_decode($sections->secs) as $sec)
@include($activeTemplate.'sections.'.$sec)
@endforeach
@endif
@endsection

@push('style')
<style>
    p {
        margin-bottom: 0;
        color: #444
    }

    .document-wrapper {
        background-color: #fff;
        box-shadow: 0 3px 35px rgba(0, 0, 0, .1);
        border-radius: 7px;
        overflow: hidden;

    }

    div[class*='col']:nth-child(odd) .document-item {
        border-right: 1px solid rgba(0, 0, 0, .1)
    }

    div[class*='col-lg-12']:nth-child(odd) .document-item {
        border-right: 0;
    }

    div[class*='col']:nth-child(1) .document-item {
        border-top: 0;
    }

    div[class*='col']:nth-child(2) .document-item {
        border-top: 0;
    }

    .dark-mode {
        background-color: #1A202C;
    }

    .dark-mode p,
    .dark-mode .share-links li a {
        color: rgba(255, 255, 255, 0.8);
    }

    .dark-mode .document-wrapper {
        box-shadow: 0 3px 25px rgba(255, 255, 255, 0.03);
    }

    .dark-mode .document-item {
        background-color: #2D3748;
        color: rgba(255, 255, 255, 0.8);
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    .dark-mode .document-item__icon,
    .dark-mode .document-item__content .title a {
        color: #fff;
    }

    .document-item {
        background-color: #fff;
        padding: 45px 35px;
        border-top: 1px solid rgba(0, 0, 0, .1);
        height: 100%;
    }

    .document-item__icon {
        font-size: 32px;
        width: 35px;
        line-height: 1px;
    }

    .document-item__content {
        width: calc(100% - 35px);
        padding-left: 15px;
    }

    .document-item__content .title {
        margin-bottom: 13px;
    }

    .document-item__content .title a {
        color: #111;
        display: inline-block;
    }

    .document-footer ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .share-links li a {
        color: #444
    }

    .share-links li:not(:last-child) {
        padding-right: 25px;
    }

    .logo img {
        max-width: 220px;
    }
</style>
@endpush
