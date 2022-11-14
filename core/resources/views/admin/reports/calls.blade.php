@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->scheduled, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Scheduled</p>
              </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->completed, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Completed</p>
              </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->canceled, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Canceled</p>
              </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{ gmdate("H\\h i\\m", $summery->duration) ?? '00 mins'}} <small></small></h1>
              </div>
              <div class="card-footer text-muted">
                <p>Duration</p>
              </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->total_users, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Total Users</p>
              </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Principal Image')</th>
                                    <th scope="col">@lang('Principal Name')</th>
                                    <th scope="col">@lang('Coach Name')</th>
                                    {{-- <th scope="col">@lang('Topic')</th> --}}
                                    <th scope="col">@lang('Date')</th>
                                    <th scope="col">@lang('Slot')</th>
                                    <th scope="col">@lang('Duration')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Call Start')</th>
                                    <th scope="col">@lang('Call End')</th>
                                    <th scope="col">@lang('Call Duration')</th>
                                    <th scope="col">@lang('Call Ratings')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($calls as $call)
                                    <tr>
                                        <td data-label="@lang('Author')">
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ asset(imagePath()['principal']['path'].'/'. $call->profile_image,imagePath()['principal']['size'])}}" alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Principal Name')">{{ $call->principal_first_name }} {{ $call->principal_last_name }} </td>
                                        <td data-label="@lang('Coach Name')">{{ $call->coach_first_name }} {{ $call->coach_last_name }} </td>
                                        {{-- <td data-label="@lang('Topic')">{{ $call->topic }}</td> --}}
                                        <td data-label="@lang('Appointment Date')">{{ $call->appt_date }}</td>
                                        <td data-label="@lang('Time Slot')">{{ $call->time_slot }}</td>
                                        <td data-label="@lang('Duration')">{{ $call->duration ?? '-' }} mins</td>
                                        <td data-label="@lang('Status')">
                                            @if ($call->status == 0)
                                                <span class="text--small badge font-weight-normal badge--warning">@lang(getCallStatus($call->status))</span>
                                            @elseif ($call->status == 1)
                                                <span class="text--small badge font-weight-normal badge--warning">@lang(getCallStatus($call->status))</span>
                                            @elseif ($call->status == 2)
                                                <span class="text--small badge font-weight-normal badge--danger">@lang(getCallStatus($call->status))</span>
                                            @elseif ($call->status == 3)
                                                <span class="text--small badge font-weight-normal badge--danger">@lang(getCallStatus($call->status))</span>
                                            @elseif ($call->status == 4)
                                                <span class="text--small badge font-weight-normal badge--success">@lang(getCallStatus($call->status))</span>
                                            @elseif ($call->status == 5)
                                                <span class="text--small badge font-weight-normal badge--dark">@lang(getCallStatus($call->status))</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Call Start')">{{ $call->call_start_at }}</td>
                                        <td data-label="@lang('Call Ended')">{{ $call->call_end_at }}</td>
                                        <td data-label="@lang('Call Duration')">{{ $call->call_duration ?? '-' }} mins</td>
                                        <td data-label="@lang('Call Ratings')">{{ $call->ratings }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $calls->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form class="form-inline float-right" method="get">
        <label class="sr-only my-1 mr-2" for="from-date">coaches</label>
        <select class="form-control form-control-sm mb-2 mr-sm-2" id="coach" name="coach">
            <option value="">All coaches</option>
            @foreach ($coaches as $coach)
                <option {{(request()->coach == $coach->user_code) ? 'selected': ''}} value="{{$coach->user_code}}">{{$coach->first_name}} {{$coach->last_name}}</option>
            @endforeach
        </select>
    
        <label class="sr-only my-1 mr-2" for="from-date">from date</label>
        <input type="date" class="form-control form-control-sm mb-2 mr-sm-2" id="from-date" value="{{request()->from_date ?? ''}}" name="from_date" placeholder="from_date">
    
        <label class="sr-only my-1 mr-2" for="to-date">to date</label>
        <input type="date" class="form-control form-control-sm mb-2 mr-sm-2" id="to-date" value="{{request()->to_date ?? ''}}" name="to_date" placeholder="to_date">
    
        <button type="submit" class="btn btn--primary box--shadow1 text--small addBtn mb-2 mr-2">@lang('Search')</button>
        <button type="submit" class="btn btn--primary box--shadow1 text--small addBtn mb-2" title="Export" name="action" value="export"><i class="fa fa-download"></i></button>
    </form>

    <!-- <a href="{{route('admin.admin.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a> -->
@endpush
