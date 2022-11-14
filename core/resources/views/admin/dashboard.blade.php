@extends('admin.layouts.app')
@section('panel')

@if(@json_decode($general->sys_version)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-right">@lang('Version') {{json_decode($general->sys_version)->version}}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p><pre  class="f-size--24">{{json_decode($general->sys_version)->details}}</pre></p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(@json_decode($general->sys_version)->message)
        <div class="row">
            @foreach(json_decode($general->sys_version)->message as $msg)
            <div class="col-md-12">
                <div class="alert border border--primary" role="alert">
                  <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                  <p class="alert__message">@php echo $msg; @endphp</p>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-over1 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-users" style="color: darkblue"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_doctors']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="color: black; font-weight: bold;">@lang('Total Coaches')</span>
                    </div>
                    <a href="{{route('admin.coaches.all')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-over1 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-users" style="color: darkblue"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_assistants']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="color: black; font-weight: bold;">@lang('Total Principals')</span>
                    </div>

                    <a href="{{route('admin.principals.all')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-over1 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-globe" style="color: darkblue"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_staff']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="color: black; font-weight: bold;">@lang('Completed Appointments')</span>
                    </div>

                    <a href="{{route('admin.callReport.all')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-over1 b-radius--10 box-shadow" >
                <div class="icon">
                                      <i class="fa fa-comments" style="color: darkblue"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount" >{{$widget['new_appointments']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small" style="color: black; font-weight: bold;">@lang('Scheduled Appointments') <br></span>

                    </div>

                    <a href="{{route('admin.appointments.all')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

    </div><!-- row end-->

@endsection

@push('script')

    <script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/chart.js.2.8.0.js')}}"></script>
    <script>
        'use strict';
        // apex-line chart
        var options = {
          chart: {
            height: 400,
            type: "area",
            toolbar: {
              show: false
            },
            dropShadow: {
              enabled: true,
              enabledSeries: [0],
              top: -2,
              left: 0,
              blur: 10,
              opacity: 0.08
            },
            animations: {
              enabled: true,
              easing: 'linear',
              dynamicAnimation: {
                speed: 1000
              }
            },
          },
          dataLabels: {
            enabled: false
          },
          series: [
            {
              name: "@lang('Appointment')",
              data: @php echo json_encode($appointment_all) @endphp,
            }
          ],
          fill: {
            type: "gradient",
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.7,
              opacityTo: 0.9,
              stops: [0, 90, 100]
            }
          },
          xaxis: {
            categories: @php echo json_encode($month_appointment) @endphp,
          },
          grid: {
            padding: {
              left: 5,
              right: 5
            },
            xaxis: {
              lines: {
                  show: false
              }
            },
            yaxis: {
              lines: {
                  show: false
              }
            },
          },
        };

        var chart = new ApexCharts(document.querySelector("#apex-line"), options);

        chart.render();
    </script>

    <script>
        'use strict';
        // apex-bar-chart js
        var options = {
            series: [{
                name: 'Total Deposit',
                data: @json($report['deposit_month_amount']->flatten())
                },
            ],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($report['months']->flatten()),
            },
            yaxis: {
                title: {
                    text: "{{$general->cur_sym}}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "{{$general->cur_sym}}" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();

    </script>

    <!-- -->
@endpush
