@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-responsive--sm">
                        <table class="default-data-table table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Principal ')</th>
                                    <th scope="col">@lang('Principal Name')</th>
                                    <th scope="col">@lang('Coach Name')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Booking Date')</th>
                                    <th scope="col">@lang('Time Slot')</th>
                                    <th scope="col">@lang('Duration')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($appointments as $item)
                                    <tr>
                                        <td data-label="@lang('Coach')">
                                            <div class="user">
                                                <div class="thumb"><img src="{{ asset(imagePath()['principal']['path'].'/'. $item->profile_image,imagePath()['principal']['size'])}}" alt="@lang('image')"></div>
                            
                                            </div>
                                        </td>
                                        <td data-label="@lang('Email')">{{ _($item->principal_first_name ) }} {{ _($item->principal_last_name ) }}</td>
                                        <td data-label="@lang('Email')">{{ _($item->coach_first_name ) }} {{ _($item->coach_last_name ) }}</td>

                                        @if ($item->status == 0)
                                            <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span></td>
                                        @elseif ($item->status == 1)
                                            <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--warning">@lang('Scheduled')</span></td>
                                        @elseif ($item->status == 2)
                                            <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--danger">@lang('Rejected')</span></td>
                                            @elseif ($item->status == 3)
                                            <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--danger">@lang('Cancelled')</span></td>
                                            @elseif ($item->status == 4)
                                            <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--danger">@lang('Incomplete')</span></td>
                                            @elseif ($item->status == 5)
                                            <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--success">@lang('Complete')</span></td>
                                        @endif

                                        <td data-label="@lang('Doctor')">{{ $item->appt_date }}</td>
                                        <td data-label="@lang('Doctor')">{{ $item->time_slot }}</td>

                                        <!-- <td data-label="@lang('Booking Date')">{{ __($item->booking_date) }}</td> -->
                                        <td data-label="@lang('Duration')">{{ __($item->duration) }} minutes</td> 

                                        <td data-label="@lang('Action')">
                                        @if ($item->status == 4 )
                                        <a href="#" class="icon-btn btn--danger removeBtn" data-route="{{ route('admin.sheduledAppointment.trashed',$item->id) }}" data-toggle="tooltip" data-original-title="Remove"><i class="la la-trash"></i></a>
                                        &nbsp;
                                        <!-- <a href="{{ route('admin.principals.addAvailable', $item->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                           Manage
                                        </a> -->
                                        
                            
                                        @elseif ($item->status == 5 )
                                    

                                        <a href="#" class="icon-btn btn--danger removeBtn" data-route="{{ route('admin.sheduledAppointment.trashed',$item->id) }}" data-toggle="tooltip" data-original-title="Remove"><i class="la la-trash"></i></a>
                                        </a>
                                        &nbsp;
                                        @elseif ($item->status == 3 )
                                    

                                    <a href="#" class="icon-btn btn--danger removeBtn" data-route="{{ route('admin.sheduledAppointment.trashed',$item->id) }}" data-toggle="tooltip" data-original-title="Remove"><i class="la la-trash"></i></a>
                                    </a>
                                    &nbsp;
                                       
                                        @elseif ($item->status == 1 )
                                       
                                        <a href="#" class="icon-btn btn--danger cancelBtn" data-route="{{ route('admin.sheduledAppointment.cancelAppointment',$item->appointments_code) }}" data-toggle="tooltip" data-original-title="Remove">Cancel</i></a>
                                        @endif
                                       
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>

    {{-- View MODAL --}}
    <div id="viewModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Appointment')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <b>@lang('Name') :</b>
                        <p id="name_show" class="mb-2"></p>
                        <b>@lang('E-mail') :</b>
                        <p id="email_show" class="mb-2"></p>
                        <b>@lang('Contact No') :</b>
                        <p id="contact_show" class="mb-2"></p>
                        <b>@lang('Booking Date') :</b>
                        <p id="date_show" class="mb-2"></p>
                        <b>@lang('Booking Time or Serial no'):</b>
                        <p id="time_show" class="mb-2"></p>
                        <b>@lang('Age') :</b>
                        <p id="age_show" class="mb-2"></p>
                        <b>@lang('Disease') :</b>
                        <p id="disease_show" class="mb-2"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="" class="edit-route" method="post">
                        @csrf
                        <input type="hidden" name="complete" value="0">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                        <button type="submit" class="btn btn--warning serviceDoneBtn">@lang('Service Done')</button>
                        <button type="button" class="btn btn--warning pendingBtn">@lang('Pending')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Remove MODAL --}}
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
                    <h5>@lang('Are you sure You want to remove this appointment') ?</h5>
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

    {{-- Cancel MODAL --}}
    <div id="cancelModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Remove Appointment')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>@lang('Are you sure You want to Cancel this appointment') ?</h5>
                </div>
                <div class="modal-footer">
                    <form action="" class="remove-route" method="get">
                        @csrf
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                        <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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

        $('.removeBtn').on('click', function(e) {
                e.preventDefault();
                var modal = $('#removeModal');
                var route = $(this).data('route');
                modal.modal('show');
                $('.remove-route').attr('action',route);
            });


        $('.cancelBtn').on('click', function(e) {
                e.preventDefault();
                var modal = $('#cancelModal');
                var route = $(this).data('route');
                modal.modal('show');
                $('.remove-route').attr('action',route);
            });

            
    })(jQuery);
    </script>
@endpush
