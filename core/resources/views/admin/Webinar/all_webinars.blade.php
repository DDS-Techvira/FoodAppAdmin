@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Id')</th>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('Coach')</th>
                                {{-- <th scope="col">@lang('Approved')</th> --}}
                                <th scope="col">@lang('Date Time')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($articles as $article)
                                <tr>
                                <td data-label="@lang('Email')">{{ $article->id }}</td>
                                    
                                    <td data-label="@lang('Username')"><a href="{{ route('admin.webinarUsers.detail', $article->webinar_code) }}">{{ $article->title  }}</a></td>
                                    <td data-label="@lang('Email')">{{ $article->first_name }}  {{ $article->last_name }}</td>
                                    {{-- <td data-label="@lang('Approved')">
                                        @if ($article->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Yes')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('No')</span>
                                        @endif
                                    </td> --}}
                                    <td data-label="@lang('Date Time')">{{ showDateTime($article->date.' '.$article->time) }}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="#" class="icon-btn btn--danger removeBtn" data-route="{{ route('admin.webinar.delete',$article->webinar_code) }}" data-toggle="tooltip" data-original-title="Remove"><i class="la la-trash"></i></a>
                                        </a>
                                        {{-- <a href="{{ route('admin.webinarUsers.manage', $article->webinar_code) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                            <i class="las la-desktop  text--shadow"></i>
                                        </a> --}}
                                        <a href="{{ route('admin.webinarUsers.detail', $article->webinar_code) }}" class="icon-btn ml-1" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                            <i class="las la-pencil-alt text--shadow"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($empty_message)}}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $articles->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>


    </div>

    {{-- Remove MODAL --}}
    <div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Webinar')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>@lang('Are you sure You want to remove this Webinar') ?</h5>
                </div>
                <div class="modal-footer">
                    <form action="" class="remove-route" method="get">
                        @csrf
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                        <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



@push('breadcrumb-plugins')
    <a href="{{route('admin.webinar.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
@push('script')
    <script>
        (function($){
        "use strict";
        $('.removeBtn').on('click', function(e) {
                e.preventDefault();
                var modal = $('#removeModal');
                var route = $(this).data('route');
                modal.modal('show');
                $('.remove-route').attr('action',route);
            });
    })(jQuery);
    </script>
@endpush