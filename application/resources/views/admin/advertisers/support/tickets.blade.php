@extends('admin.layouts.app')

@section('panel')
@include('admin.components.tabs.advertiser_ticket')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Opened By')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.ticket.view', $item->id) }}" class="fw-bold text--muted">
                                        @lang('Ticket')#{{ $item->ticket }} - {{ strLimit($item->subject,30) }} </a>
                                </td>

                                <td>
                                    @if($item->user_id)
                                    <a href="{{ route('admin.advertisers.detail', $item->user_id) }}">
                                        {{@$item->advertisers->fullname}}</a>
                                    @else
                                    <p class="fw-bold"> {{$item->name}}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($item->priority == 1)
                                    <span class="badge badge--dark">@lang('Low')</span>
                                    @elseif($item->priority == 2)
                                    <span class="badge  badge--warning">@lang('Medium')</span>
                                    @elseif($item->priority == 3)
                                    <span class="badge badge--danger">@lang('High')</span>
                                    @endif
                                </td>
                                <td>
                                    @php echo $item->statusBadge; @endphp
                                </td>
                                <td>
                                    <a title="@lang('Details')" href="{{ route('admin.ticket.view', $item->id) }}"
                                        class="btn btn-sm btn--primary ms-1">
                                        <i class="las la-eye text--shadow"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($items->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($items) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>
@endsection
