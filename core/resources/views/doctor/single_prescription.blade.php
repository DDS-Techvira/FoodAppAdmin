@extends('doctor.layouts.app')

@section('panel')

</div>
    <div class="row mb-none-30">
        <div class="col-lg-8 col-md-8 mb-30">

            <div class="card b-radius--5 overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-flex p-3 bg--primary">
                        <div class="avatar avatar--lg">
                            <img src="{{ getImage(imagePath()['staff']['path'].'/'. $prescription->image,imagePath()['staff']['size'])}}" alt="@lang('profile-image')">
                        </div>
                        <div class="pl-3">
                            <h4 class="text--white">{{$prescription->name}}</h4>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Date')</span>
                            <span class="list-right font-weight-bold">{{$prescription->date}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Disease')</span>
                            <span  class="font-weight-bold list-right">{{$prescription->disease}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Note')</span>
                            <span  class="font-weight-bold list-right">{{$prescription->note}}</span>
                        </li>

                        <div class="pl-3">
                            <span class="list-left">@lang('Attachments')</span>
                        </div>

                        @foreach ($prescription_images as $item)
                        <img src="{{ getImage('assets/appointment/prescription/'. @$item->attachment_name )}}" alt="@lang('No Images')">
                      @endforeach





                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex p-3 bg--primary">

                        <div class="pl-3">
                            <h4 class="text--white">Appointment Details</h4>
                        </div>
                    </div>
<br/>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list-left">@lang('Date')</span>
                        <span class="list-right font-weight-bold">{{$prescription->booking_date}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list-left">@lang('Time')</span>
                        <span  class="font-weight-bold list-right">{{$prescription->time_serial }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list-left">@lang('Patient Disease Note')</span>
                        <span  class="font-weight-bold list-right">{{$prescription->disease}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list-left">@lang('Patient Age')</span>
                        <span  class="font-weight-bold list-right">{{$prescription->age}}</span>
                    </li>
                </div>
            </div>
        </div>



@endsection

@push('breadcrumb-plugins')
    {{-- <a href="{{route('doctor.profile')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-user"></i>@lang('Profile Setting')</a> --}}
@endpush

@push('style')
    <style>
        .list-left{
            width: 40%;
        }
        .list-right{
            width: calc(100% - 40%);
        }
    </style>
@endpush
