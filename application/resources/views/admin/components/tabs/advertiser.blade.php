<div class="row">

    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.advertisers.active') ? 'active' : '' }}"
                    href="{{route('admin.advertisers.active')}}">@lang('Active')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.advertisers.banned') ? 'active' : '' }}"
                    href="{{route('admin.advertisers.banned')}}">@lang('Banned')
                    @if($bannedAdvertiserCount)
                    <span class="badge rounded-pill bg--white text-muted">{{$bannedAdvertiserCount}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.advertisers.email.unverified') ? 'active' : '' }}"
                    href="{{route('admin.advertisers.email.unverified')}}">@lang('Email Unverified')
                    @if($emailUnverifiedAdvertiserCount)
                    <span class="badge rounded-pill bg--white text-muted">{{$emailUnverifiedAdvertiserCount}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.advertisers.mobile.unverified') ? 'active' : '' }}"
                    href="{{route('admin.advertisers.mobile.unverified')}}">@lang('Mobile Unverified')
                    @if($mobileUnverifiedAdvertiserCount)
                    <span class="badge rounded-pill bg--white text-muted">{{$mobileUnverifiedAdvertiserCount}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.advertisers.with.balance') ? 'active' : '' }}"
                    href="{{route('admin.advertisers.with.balance')}}">@lang('With Balance')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.advertisers.all') ? 'active' : '' }}"
                    href="{{route('admin.advertisers.all')}}">@lang('All Advertiser')
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.advertisers.notification.all') ? 'active' : '' }}"
                    href="{{route('admin.advertisers.notification.all')}}">@lang('Notification to Advertiser')
                </a>
            </li>
        </ul>
    </div>
</div>
