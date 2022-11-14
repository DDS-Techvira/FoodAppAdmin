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
                                <th scope="col">@lang('Start Date')</th>
                                <th scope="col">@lang('End Date')</th>
                                <th scope="col">@lang('Start Time')</th>
                                <th scope="col">@lang('End Time')</th>
                                <th scope="col">@lang('Description')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($availability as $available)
                                <tr>
                                    <td data-label="@lang('Email')">{{ $available->from_date }}</td>
                                    <td data-label="@lang('Email')">{{ $available->to_date }}</td>
                                    <td data-label="@lang('Email')">{{ strtoupper($available->start_time) }}</td>
                                    <td data-label="@lang('Email')">{{ strtoupper($available->end_time) }}</td>
                                    <td data-label="@lang('Description')">{{ $available->description }}</td>
                                    <td data-label="@lang('Joined On')">{{ showDateTime($available->created_at) }}</td>
                                    <td data-label="@lang('Action Availability')">
                                        <a href="{{ route('admin.scheduleEdit.all',[$available->avail_code] ) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                        Edit
                                        </a>
                                        &nbsp;
                                        <a href="#" class="icon-btn btn--danger removeBtn" data-route="{{ route('admin.coachavailability.delete',$available->id) }}" data-toggle="tooltip" data-original-title="Remove"><i class="la la-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">No data available</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $availability->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

    <div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Remove Appointment')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>@lang('Are you sure You want to remove this Availability') ?</h5>
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
    <a href="{{route('admin.availabilityCoach.all')}}" class="btn btn--primary box--shadow1 text--small float-right"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

@push('script')
    <script>
        (function($){

        "use strict";
        $('.viewBtn').on('click', function() {
            var modal = $('#viewModal');
            var resourse = $(this).data('resourse');
            var route = $(this).data('route');

            modal.find('.serviceDoneBtn').hide();
            modal.find('.pendingBtn').hide();
            modal.find('input[name=complete]').val(0);

            $('.edit-route').attr('action',route);

            $('#name_show').text(resourse.name);
            $('#email_show').text(resourse.email);
            $('#contact_show').text(resourse.mobile);
            $('#date_show').text(resourse.booking_date);
            $('#time_show').text(resourse.time_serial);
            $('#age_show').text(resourse.age);
            $('#disease_show').text(resourse.disease);

            if(resourse.is_complete) {

                modal.find('.serviceDoneBtn').hide();

            }
            if(!resourse.is_complete && resourse.p_status != 2) {

                modal.find('.serviceDoneBtn').show();

            }
            if(!resourse.is_complete && resourse.p_status == 2) {

                modal.find('.pendingBtn').show();

            }

            modal.find('.serviceDoneBtn').on('click', function() {
                modal.find('input[name=complete]').val(1);
            });
        });

        $('.removeBtn').on('click', function() {
                var modal = $('#removeModal');
                var route = $(this).data('route');
                modal.modal('show');
                $('.remove-route').attr('action',route);
            });


        $('.cancelBtn').on('click', function() {
                var modal = $('#cancelModal');
                var route = $(this).data('route');
                modal.modal('show');
                $('.remove-route').attr('action',route);
            });

            
    })(jQuery);
    </script>
@endpush
