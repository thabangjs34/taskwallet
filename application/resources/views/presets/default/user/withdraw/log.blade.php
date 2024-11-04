@extends($activeTemplate.'layouts.user.master')
@section('content')

<div class="body-wrapper">
    <div class="table-content">
        <div class="m-0">
            <div class="list-card">
                <form action="">
                    <div class="row search-dash justify-content-end mb-3">
                        <div class="col-3">
                            <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                            placeholder="@lang('Search by transactions')">
                            <i class="las la-search"></i>
                        </div>
                    </div>
                </form>
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway')</th>
                                    <th class="text-center">@lang('Initiated')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Conversion')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdraws as $withdraw)
                                <tr>
                                    <td>
                                         {{__(@$withdraw->method->name) }}
                                    </td>
                                    <td class="text-center">
                                        {{ showDateTime($withdraw->created_at) }}
                                    </td>
                                    <td class="text-center">
                                        {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount ) }} - <span class="text-danger" title="@lang('charge')"> {{showAmount($withdraw->charge)}} </span>
                                    </td>
                                    <td class="text-center">
                                        1 {{ __($general->cur_text) }} = {{ showAmount($withdraw->rate) }}
                                        {{__($withdraw->currency) }}

                                    </td>
                                    <td class="text-center">
                                        @php echo $withdraw->statusBadge @endphp
                                    </td>
                                    <td class="table-dropdown">
                                        <i class="fas fa-ellipsis-v" data-bs-toggle="dropdown"></i>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item detailBtn" href="javascript:void(0)"
                                                data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                                @if($withdraw->status == 3)
                                                data-admin_feedback="{{ $withdraw->admin_feedback }}"
                                                @endif >@lang('View')</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        @if($withdraws->hasPages())
                        <div class="text-end">
                            {{ $withdraws->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- APPROVE MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close btn btn--base btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData">

                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--base" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    (function ($) {
        "use strict";

        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');
            var userData = $(this).data('user_data');
            var html = ``;
            userData.forEach(element => {
                if (element.type != 'file') {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                }
            });
            modal.find('.userData').html(html);

            if ($(this).data('admin_feedback') != undefined) {
                var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
            } else {
                var adminFeedback = '';
            }

            modal.find('.feedback').html(adminFeedback);

            modal.modal('show');
        });

    })(jQuery);

</script>
@endpush
