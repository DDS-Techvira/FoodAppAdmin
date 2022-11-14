@extends('doctor.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="default-data-table table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Added By')</th>
                                <th scope="col">@lang('Booking Date')</th>
                                <th scope="col">@lang('Time Or Serial no')</th>
                                <th scope="col">@lang('Payment Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointments as $item)
                            <tr>
                                <td data-label="@lang('Name')">{{ $item->name }}</td>
                                <td data-label="@lang('Email')">{{ $item->email }}</td>

                                @if ($item->staff)
                                    <td data-label="@lang('Added By')">{{ $item->relationStaff->name }} <span class="text--small badge font-weight-normal badge--success">@lang('Staff')</span></td>
                                @elseif($item->assistant)
                                    <td data-label="@lang('Added By')">{{ $item->relationAssistant->name }} <span class="text--small badge font-weight-normal badge--success">@lang('Assistant')</span></td>
                                @elseif($item->entry_doctor)
                                    <td data-label="@lang('Added By')">{{ $item->doctor->name }} <span class="text--small badge font-weight-normal badge--success">@lang('Doctor')</span></td>
                                @elseif($item->admin)
                                    <td data-label="@lang('Added By')">{{ $item->relationAdmin->name }} <span class="text--small badge font-weight-normal badge--success">@lang('Admin')</span></td>
                                @elseif($item->site)
                                    <td data-label="@lang('Added By')">@lang('From Site') <span class="text--small badge font-weight-normal badge--success">@lang('Site')</span></td>
                                @else
                                    <td data-label="@lang('Added By')"></td>
                                @endif

                                <td data-label="@lang('Booking Date')">{{ $item->booking_date }}</td>
                                <td data-label="@lang('Time Or Serial no')">{{ $item->time_serial }}</td>
                                @if ($item->p_status == 0)
                                    <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--danger">@lang('Pay in cash')</span></td>
                                @elseif ($item->p_status == 1)
                                    <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--success">@lang('Paid')</span></td>
                                @elseif ($item->p_status == 2)
                                    <td data-label="@lang('Payment Status')"><span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span></td>
                                @endif
                                <td data-label="@lang('Action')">
                                    <a href="" data-route="{{ route('doctor.appointment.view',$item->id) }}" data-resourse="{{ $item }}" data-toggle="modal" data-target="#viewModal"
                                        class="icon-btn bg--success ml-1 viewBtn">
                                    <i class="la la-eye"></i>
                                    </a>
                                    <a href="" data-route="{{ route('doctor.appointment.view',$item->id) }}" data-resourse="{{ $item }}" data-toggle="modal" data-target="#addModal"
                                        class="icon-btn bg--primary ml-1 addBtn">
                                    Add Prescription
                                    </a>
                                    @if ($item->p_status == 0)
                                        <a href="" data-route="{{ route('doctor.appointment.remove',$item->id) }}" data-toggle="modal" data-target="#removeModal"
                                            class="icon-btn bg--danger ml-1 removeBtn">
                                        <i class="la la-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $appointments->links('doctor.partials.paginate') }}
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

        {{-- Add Prescription MODAL --}}
        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Add Prescription')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="message-submit-form"  >
                            @csrf


                            <div class="form-group">
                                <label class="text-muted">@lang('Disease Details')</label>
                                <textarea name="disease" id="disease" class="form-control"  rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">@lang('Prescription Notes')</label>
                                <textarea name="note" id="note" class="form-control"  rows="2"></textarea>
                            </div>
                            <div id="selectedDocument" name="selectedDocument" hidden></div>
                            <div id="doctor_id" name="doctor_id" hidden></div>
                            <div id="patient_id" name="patient_id" hidden></div>
                            <div id="appointment_id" name="appointment_id" hidden></div>
                        </form>
                        <div class="form-group">
                            <label class="text-muted">@lang('Attachments')</label>

                            <form method="post" action="{{route('prescription.upload')}}"
                                 enctype="multipart/form-data"
                                class="dropzone" id="dropzone">
                                {{csrf_field()}}
                            </form>

                        </div>
                    </div>
                    <div class="modal-footer">

                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                            <button id="message-submit" class="btn btn--success">@lang('Submit')</button>
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
                    <h5>@lang('Are you sure You want to remove this appointment?')</h5>
                </div>
                <div class="modal-footer">
                    <form action="" class="remove-route" method="post">
                        @csrf
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                        <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {
            $("#message-submit").click(function (e) {
                e.preventDefault();
                var validFunction = true;

                // if ($('#doctor_id').val() == '') {
                    // Swal.fire({
                    //     position: 'center',
                    //     icon: 'error',
                    //     title: 'Doctor Selection Required!',
                    //     showConfirmButton: false,
                    //     timer: 1200
                    // })
                //     validFunction = false;
                // }

                // if ($('textarea#symptoms').val() == '') {
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'error',
                //         title: 'Symptoms are Required!',
                //         showConfirmButton: false,
                //         timer: 1200
                //     })
                //     validFunction = false;
                // }

                // if ($('textarea#message_for_doctor').val() == '') {
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'error',
                //         title: 'Message For Doctor Required!',
                //         showConfirmButton: false,
                //         timer: 1200
                //     })
                //     validFunction = false;
                // }

                if (validFunction) {
                    $.ajax({
                        url: '/prescription/store',
                        type: 'post',
                        data: $("#message-submit-form").serialize(),
                        success: function (data) {
                            $('#addModal').modal('hide');
                            Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Prescription Added!',
                        showConfirmButton: true,
                        timer: 2200
                    })
                    location.reload()

                        },
                        error: function () {

                        }
                    });
                }
            });
        });
        (function ($) {
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

            $('.addBtn').on('click', function() {
                var modal = $('#addModal');
                var resourse = $(this).data('resourse');
                var route = $(this).data('route');

                modal.find('.serviceDoneBtn').hide();
                modal.find('.pendingBtn').hide();
                modal.find('input[name=complete]').val(0);

                $('.edit-route').attr('action',route);

                        $('#doctor_id').html('');
                         $('#doctor_id').append('<input type="text" name="doctor_id" value="' + resourse.doctor_id + '" >');

                         $('#patient_id').html('');
                         $('#patient_id').append('<input type="text" name="patient_id" value="' + resourse.patient + '" >');

                         $('#appointment_id').html('');
                         $('#appointment_id').append('<input type="text" name="appointment_id" value="' + resourse.id + '" >');

                // $('#name_show').text(resourse.name);
                // $('#email_show').text(resourse.email);
                // $('#contact_show').text(resourse.mobile);
                // $('#date_show').text(resourse.booking_date);
                // $('#time_show').text(resourse.time_serial);
                // $('#age_show').text(resourse.age);
                // $('#disease_show').text(resourse.disease);

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

                $('.remove-route').attr('action',route);

            });

            var selected_doc = [];

            function setSelectedDocList(file_name) {
                // alert(file_name);
                selected_doc.push(file_name);
                $('#selectedDocument').html('');
                for (var i = 0; i < selected_doc.length; ++i) {
                    $('#selectedDocument').append('<input type="text" name="selectedDocument[]" value="' + selected_doc[i] + '" >');
                }
            }

            function removeFromSelectedDocList(file_name) {
                for (var i = 0; i < selected_doc.length; ++i) {// is unchecked then remove from array
                    if (selected_doc[i] == file_name) {
                        selected_doc.splice(i, 1);
                    }
                }

                $('#selectedDocument').html('');
                for (var i = 0; i < selected_doc.length; ++i) {
                    $('#selectedDocument').append('<input type="text" name="selectedDocument[]" value="' + selected_doc[i] + '" >');
                }
            }

                Dropzone.options.dropzone =
                    {
                maxFilesize: 100,
                renameFile: function (file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    setSelectedDocList(time + file.name);
                    return time + file.name;
                },
                acceptedFiles: "",
                addRemoveLinks: true,
                timeout: 100000,
                removedfile: function (file) {
                    var name = file.upload.filename;
                    removeFromSelectedDocList(name);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("image/delete") }}',
                        data: {filename: name},
                        success: function (data) {
                            console.log("File has been successfully removed!!");
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },

                success: function (file, response) {
                    console.log(response);
                },
                error: function (file, response) {
                    return false;
                }
                };
        })(jQuery);

    </script>
@endpush

