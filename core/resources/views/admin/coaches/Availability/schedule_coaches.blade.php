@extends('admin.layouts.app')
@push('style')
<link rel="stylesheet" href="{{ asset('assets/doctor/css/bootstrap-material-datetimepicker-bs4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/doctor/css/Material+Icons.css')}}">
@endpush
@section('panel')
<div class="row justify-content-center">
    <div class="col-md-12">
        <form action="{{ route('admin.scheduleManage.store') }}" method="post">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-row mb-2">
                        <div class="col-md-3 start-time  ">
                            <label class="form-control-label font-weight-bold">@lang('Start Date')</label>
                            <input class="form-control" type="date" placeholder="@lang('No time selected yet')"
                                name="from_date" value="{{ old('from_date') }}"/>
                        </div>

                        <input class="form-control" type="hidden" hidden value="{{$coach->user_code}}" name="coach_code">
                                
                        <div class="col-md-3 end-time  ">
                            <label class="form-control-label font-weight-bold">@lang('End Date')</label>
                            <input class="form-control" type="date" placeholder="@lang('No time selected yet')"
                                name="to_date" value="{{ old('to_date') }}"/>
                        </div>
                    </div>

                    @php
                        $options = ['06:00 AM', '06:30 AM', '07:00 AM', '07:30 AM', '08:00 AM', '08:30 AM', '09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM', '05:30 PM', '06:00 PM', '06:30 PM', '07:00 PM', '07:30 PM', '08:00 PM', '08:30 PM', '09:00 PM', '09:30 PM'];
                    @endphp
                    <div class="form-row mb-2">
                        <div class="col-md-3">
                            <label class="form-control-label font-weight-bold">New Start Time</label>
                            <select class="form-control" name="start_time" value="0.00" placeholder="@lang('Click here')" required>
                                <option disabled selected>@lang('Click here')</option>
                                @foreach ($options as $option)
                                    <option {{old('start_time') == $option ? 'selected' : ''}} >{{$option}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label font-weight-bold">New End Time</label>
                            <select class="form-control" name="end_time" value="0.00" placeholder="@lang('Click here')" required>
                                <option disabled selected>@lang('Click here')</option>
                                @foreach ($options as $option)
                                    <option {{old('end_time') == $option ? 'selected' : ''}} >{{$option}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col-md-6 description ">
                            <label class="form-control-label font-weight-bold">@lang('Description')</label>
                            <textarea class="form-control" placeholder="@lang('Description')"
                                name="description" rows="2">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <br>

                    <div class="form-row mb-2">
                        <div class="col-md-3">
                            <label class="form-control-label font-weight-bold">Recurring</label> 
                            <br />

                            <input type="checkbox" id="day1" name="days[]" value="MO">
                            <label for="day1">Monday</label><br>
                            
                            <input type="checkbox" id="day2" name="days[]" value="TU">
                            <label for="day2">Tuesday</label><br>
                            
                            <input type="checkbox" id="day3" name="days[]" value="WE">
                            <label for="day3">Wenesday</label><br> 
                            
                            <input type="checkbox" id="day4" name="days[]" value="TH">
                            <label for="day4">Thursday</label><br> 
                            
                            <input type="checkbox" id="day5" name="days[]" value="FR">
                            <label for="day5">Friday</label><br> 
                            
                            <input type="checkbox" id="day6" name="days[]" value="SA">
                            <label for="day6">Saturday</label><br> 
                            
                            <input type="checkbox" id="day7" name="days[]" value="SU">
                            <label for="day7">Sunday</label><br> 

                            <input type="hidden" id="day7" name="days[]" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--  -->
@endsection

@push('script')

<script>

    (function ($) {
    'use strict';



        var check_slot_type = $('select[name="slot_type"]').val();
        var time_div = `<div class="card-body time_div">
                            <div class="form-row">
                             
                                <div class="col-md-4">
                                    <label class="form-control-label font-weight-bold">New Start Time</label>
                                    <input class="form-control timepicker" type="text" name="start_time" value="0.00" placeholder="@lang('Click here')" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label font-weight-bold">New End Time</label>
                                    <input class="form-control timepicker" type="text" name="end_time" value="0.00" placeholder="@lang('Click here')" required>
                                </div>
                            </div>
                        </div>`;
        var serial_div = `<div class="card-body serial_div">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label class="form-control-label font-weight-bold">Maximum Serial</label>
                                    <input class="form-control" type="number" name="max_serial"  value="" placeholder="@lang('Example') : 20" required>
                                </div>
                            </div>
                        </div>`;

        var timePicker = function () {
            $('.timepicker').bootstrapMaterialDatePicker({
                format: 'HH:mm',
                shortTime: false,
                date: false,
                time: true,
                monthPicker: false,
                year: false,
                switchOnClick: true
            });
        }

        // if (check_slot_type == 2) {

        //     $('#slot-value').html(time_div);
        // }
        // if (check_slot_type == 1) {

        //     $('#slot-value').html(serial_div);
        // }
        // $('#slot-value').html(time_div);

        $("#slot-type").on('change',function () {
            var check_slot_type = $('select[name="slot_type"]').val();
            if (check_slot_type == 1) {

                $('#slot-value').html(serial_div);
                $('.start-time').addClass('d-none');
                $('.end-time').addClass('d-none');
                $('.time_div').remove();
            }
            if (check_slot_type == 2) {

                $('#slot-value').html(time_div);
                $('.start-time').removeClass('d-none');
                $('.end-time').removeClass('d-none');
                $('.serial_div').remove();
            }
            timePicker();

        });

        timePicker();
    })(jQuery);

</script>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/doctor/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('assets/doctor/js/bootstrap-material-datetimepicker-bs4.min.js') }}"></script>
@endpush
