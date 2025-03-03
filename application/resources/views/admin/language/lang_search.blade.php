@extends('admin.layouts.app')
@section('panel')

<div id="app">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="row justify-content-between mt-3">
                        <div class="col-md-7">
                            <ul>
                                <li>
                                    <h5>@lang('Language Keywords of') {{ __($lang->name) }}</h5>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-5 mt-md-0 mt-3">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#searchModal"
                                class="btn btn-sm btn--primary float-end"><i class="fas fa-search"></i> @lang('Search Key') </button>

                                <button type="button" data-bs-toggle="modal" data-bs-target="#searchAndReplaceModal"
                                class="btn btn-sm btn--primary float-end me-2"><i class="fas fa-exchange-alt"></i> @lang('Search And Replace') </button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                                class="btn btn-sm btn--primary float-end me-2"><i class="fa fa-plus"></i> @lang('Add
                                New Key') </button>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table white-space-wrap" id="myTable">
                            <thead>
                                <tr>
                                    <th>
                                        @lang('Key')
                                    </th>
                                    <th>
                                        {{__($lang->name)}}
                                    </th>

                                    <th class="w-85">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($paginatedData as $k => $language)

                                <tr>
                                    <td class="white-space-wrap">{{$language['key']}}</td>
                                    <td class="text-left white-space-wrap">{{$language['value']}}</td>


                                    <td>
                                        <a title="@lang('Edit')" href="javascript:void(0)" data-bs-target="#editModal"
                                            data-bs-toggle="modal" data-title="{{$language['key']}}" data-key="{{$language['key']}}"
                                            data-value="{{$language['value']}}" class="editModal btn btn-sm btn--primary">
                                            <i class="la la-pencil"></i>
                                        </a>

                                        <a title="@lang('Remove')" href="javascript:void(0)" data-key="{{$language['key']}}"
                                            data-value="{{$language['value']}}" data-bs-toggle="modal" data-bs-target="#DelModal"
                                            class="btn btn-sm btn--danger deleteKey">
                                            <i class="la la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                                @endforelse



                            </tbody>
                        </table>
                    </div>
                    {{ $paginatedData->links() }}
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel"> @lang('Add New')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.language.store.key',$lang->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="key" class="fw-bold">@lang('Key')</label>
                            <input type="text" class="form-control" id="key" name="key" value="{{old('key')}}" required>

                        </div>
                        <div class="form-group">
                            <label for="value" class="fw-bold">@lang('Value')</label>
                            <input type="text" class="form-control" id="value" name="value" value="{{old('value')}}"
                                required>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global"> @lang('Save')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">@lang('Edit')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>

                <form action="{{route('admin.language.update.key',$lang->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="inputName" class="fw-bold form-title"></label>
                            <input type="text" class="form-control" name="value" required>
                        </div>
                        <input type="hidden" name="key">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Modal for DELETE -->
    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="DelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DelModalLabel"> @lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this key from this language?')</p>
                </div>
                <form action="{{route('admin.language.delete.key',$lang->id)}}" method="post">
                    @csrf
                    <input type="hidden" name="key">
                    <input type="hidden" name="value">
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel"> @lang('Search Keyword')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>

            <form action="{{route('admin.language.manage.search')}}" method="get">
                @csrf
                <input type="hidden" name="id" value="{{$lang->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="key" class="fw-bold">@lang('SearchKey')</label>
                        <input type="text" class="form-control" id="search_key" name="search_key" value="{{old('search_key')}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global"> @lang('Search')</button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade" id="searchAndReplaceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel"> @lang('Search and Replace ')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>

            <form action="{{route('admin.language.manage.search.replace')}}" method="get">
                @csrf
                <input type="hidden" name="id" value="{{$lang->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="key" class="fw-bold">@lang('Search Keyword')</label>
                        <input type="text" class="form-control" id="key" name="key" value="{{old('key')}}" required>

                    </div>
                    <div class="form-group">
                        <label for="value" class="fw-bold">@lang('Replace Value')</label>
                        <input type="text" class="form-control" id="value" name="value" value="{{old('value')}}"
                            required>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global"> @lang('Replace')</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection






@push('script')
<script>
    (function ($) {
        "use strict";
        $(document).on('click', '.deleteKey', function () {
            var modal = $('#DelModal');
            modal.find('input[name=key]').val($(this).data('key'));
            modal.find('input[name=value]').val($(this).data('value'));
        });
        $(document).on('click', '.editModal', function () {
            var modal = $('#editModal');
            modal.find('.form-title').text($(this).data('title'));
            modal.find('input[name=key]').val($(this).data('key'));
            modal.find('input[name=value]').val($(this).data('value'));
        });


        $(document).on('click', '.importBtn', function () {
            $('#importModal').modal('show');
        });
        $(document).on('click', '.import_lang', function (e) {
            var id = $('.select_lang').val();

            if (id == '') {
                notify('error', 'Invalide selection');

                return 0;
            } else {
                $.ajax({
                    type: "post",
                    url: "{{route('admin.language.import.lang')}}",
                    data: {
                        id: id,
                        toLangid: "{{$lang->id}}",
                        _token: "{{csrf_token()}}"
                    },
                    success: function (data) {
                        if (data == 'success') {
                            notify('success', 'Import Data Successfully');
                            window.location.href = "{{url()->current()}}"
                        }
                    }
                });
            }

        });
    })(jQuery);
</script>
@endpush
