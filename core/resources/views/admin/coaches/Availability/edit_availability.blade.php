@extends('admin.layouts.app')

@section('panel')
<style type="text/css">
    .form-check {
        width: 50%;
        float: left;
    }
</style>
<div class="row ">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($availability_deatils as $key => $item)
                                <a class="nav-link {{ $date == $item->date ? 'active' : (!$date && $key==0 ? 'active' : '') }}" id="v-pills-{{$item->date}}-tab" data-toggle="pill" href="#v-pills-{{$item->date}}" role="tab" aria-controls="v-pills-{{$item->date}}" aria-selected="false">{{$item->date}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content py-3 pr-3" id="v-pills-tabContent" style="min-height: 200px;">
                            @foreach ($availability_deatils as $key => $item)
                                @php
                                    $start_time = \Carbon\Carbon::parse('6:00 AM');
                                    $start_time_30 = \Carbon\Carbon::parse('6:00 AM');
                                    $start_time_60 = \Carbon\Carbon::parse('6:00 AM');
                                    $end_time = \Carbon\Carbon::parse('10:00 PM');

                                    $start_date = \Carbon\Carbon::parse($availability->from_date);
                                    $end_date = \Carbon\Carbon::parse($availability->to_date);
                                    $total_dates = $end_date->diffInDays($start_date);

                                    $total_min = $end_time->diffInMinutes($start_time);
                                    $total_slot_30 = $total_min / 30;
                                    $total_slot_60 = $total_min / 60;
                                @endphp
                                <div class="tab-pane fade {{ $date == $item->date ? 'show active' : (!$date && $key==0 ? 'show active' : '') }}" id="v-pills-{{$item->date}}" role="tabpanel" aria-labelledby="v-pills-{{$item->date}}-tab">
                                    <form action="{{ route('admin.scheduleEdit.update',[$item->avail_code, $item->date] ) }}" method="post">
                                        @csrf
                                        <div class="card-group">
                                            <div class="card">
                                                <div class="card-header">
                                                    30 minute slots
                                                </div>
                                                <div class="card-body">
                                                    @for ($i=1; $i <= $total_slot_30; $i++)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" {{in_array(date('h:i A',strtotime($start_time_30)), $item->time_slots_30 ?? []) ? 'checked' : ''}} name="time_slots_30[]" value="{{date('h:i A',strtotime($start_time_30))}}" id="30-min-slots-{{$i}}">
                                                            <label class="form-check-label" for="30-min-slots-{{$i}}" style="font-size: 14px;">
                                                                {{date('h:i A',strtotime($start_time_30))}}
                                                            </label>
                                                        </div>
                                                        @php
                                                            $start_time_30->addMinutes(30);
                                                        @endphp
                                                    @endfor
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header">
                                                    60 minute slots
                                                </div>
                                                <div class="card-body">
                                                    @for ($i=1; $i <= $total_slot_60; $i++)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" {{in_array(date('h:i A',strtotime($start_time_60)), $item->time_slots_60 ?? []) ? 'checked' : ''}} name="time_slots_60[]" value="{{date('h:i A',strtotime($start_time_60))}}" id="60-min-slots-{{$i}}">
                                                            <label class="form-check-label" for="60-min-slots-{{$i}}" style="font-size: 14px;">
                                                                {{date('h:i A',strtotime($start_time_60))}}
                                                            </label>
                                                        </div>
                                                        @php
                                                            $start_time_60->addMinutes(60);
                                                        @endphp
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="avail_code" value="{{$item->avail_code}}"/>
                                        <input type="hidden" name="date" value="{{$item->date}}"/>
                                        <button type="submit" class="btn btn--primary box--shadow1 text--small addBtn my-3 float-right">@lang('Save')</button>
                                    </form> 
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.coachavailabilityList.all', $availability->coach_code)}}" class="btn btn--primary box--shadow1 text--small float-right"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

@push('script')
<script>
    (function($){
        "use strict";
        $(document).on('click', '.available-time', function(){
            var cls = $(this).parent('.time-serial-parent').find('.btn--success').removeClass('btn--success disabled').addClass('btn--primary');
            $('.time').val($(this).data('value'));
            $(this).removeClass('btn--primary');
            $(this).addClass('btn--success disabled');
        });
    })(jQuery);
</script>
@endpush
