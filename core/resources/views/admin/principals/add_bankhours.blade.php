@extends('admin.layouts.app')
@php

$states = json_decode($sectors);
@endphp
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ asset(imagePath()['principal']['path'].'/'. $doctor->profile_image,imagePath()['principal']['size'])}}" alt="@lang('profile-image')"
                                 class="b-radius--10 w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{$doctor->name}}</h4>
                            <span class="text--small">@lang('Joined On') <strong>{{date('d M, Y h:i A',strtotime($doctor->created_at))}}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Principal information')</h5>
                    <ul class="list-group">

                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">{{$doctor->username}}</span>
                        </li> --}}

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @switch($doctor->status)
                                @case(1)
                                <span class="badge badge-pill bg--success">@lang('Active')</span>
                                @break
                                @case(0)
                                <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                                @break
                            @endswitch
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Name')
                            <span class="font-weight-bold">{{$doctor->first_name}} {{$doctor->last_name}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span class="font-weight-bold">{{$doctor->email}}</span>
                        </li>


                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Contact No')
                            <span class="font-weight-bold">{{$doctor->mobile_no}}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Doctor action')</h5>
                    <a href="{{ route('admin.doctors.login.history.single', $doctor->id) }}"
                       class="btn btn--primary btn--shadow btn-block btn-lg">
                       @lang('Login Logs')
                    </a>
                    <a href="{{route('admin.doctors.email.single',$doctor->id)}}"
                       class="btn btn--danger btn--shadow btn-block btn-lg">
                        @lang('Send Email')
                    </a>
                </div>
            </div> --}}
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$doctor->name}} @lang('Available Time')</h5>

                    <form action="{{ route('admin.principals.updateBankHours') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div id="piechart" ></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Month') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="month" name="month"
                                           value="{{old('month') ?? date('Y-m')}}" min="{{date('Y-m')}}" required>
                                </div>
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Add Time in Minutes') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="add_time"
                                           value="{{ old('add_time') }}" required>
                                </div>
                            </div>
                            <input hidden class="form-control" type="text" name="user_code"
                                           value="{{$doctor->user_code}}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div>
                        <form action="{{ route('admin.principals.resetBankHours', $doctor->user_code) }}" method="POST" class="form-inline">
                            @csrf
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Month') <span
                                                class="text-danger">*</span></label>
                                    </div>
                            </div> --}}
                            <input class="form-control mr-3" type="month" name="reset_month"
                                   value="{{ old('reset_month') ?? date('Y-m')}}" min="{{date('Y-m')}}" required>

                            <button type="submit" class="btn btn--primary btn-lg" data-toggle="tooltip" title="" data-original-title="@lang('Reset Hours')">
                                Reset Hours
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/chart.js.2.8.0.js')}}"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Year', 'Products'],
            ['Available  {{$available_time}} Minutes', {{$available_time}}],
            ['Spent  {{$spent_time}} Minutes',  {{$spent_time}}],
        ]);

          var options = {
            title: 'Bank Hours Availability',
            is3D: false,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));

          chart.draw(data, options);
        }
      </script>



    <!-- -->
@endpush
