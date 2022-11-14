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
                                <th scope="col">@lang('Coach Profile Image')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Mobile No')</th>
                                <!-- <th scope="col">@lang('Joined On')</th> -->
                                {{-- <th scope="col">@lang('Featured')</th> --}}
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($coaches as $coach)
                                @continue($coach->user_type != 'coach')
                                <tr>
                                    <td data-label="@lang('Coach')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ asset(imagePath()['coach']['path'].'/'. $coach->profile_image,imagePath()['coach']['size'])}}" alt="@lang('image')"></div>
                                            <span class="name">{{$coach->name}}</span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Username')"><a href="{{ route('admin.coaches.detail', $coach->id) }}">{{ $coach->first_name }} {{ $coach->last_name }}</a></td>
                                    <td data-label="@lang('Email')">{{ $coach->email }}</td>
                                    <td data-label="@lang('Email')">{{ $coach->mobile_no }}</td>
                                    {{-- <td data-label="@lang('Total Earn')">{{ round($coach->balance) }} {{ $general->cur_sym }}</td> --}}
                                    <!-- <td data-label="@lang('Joined On')">{{ showDateTime($coach->created_at) }}</td> -->
                                    {{-- <td data-label="@lang('Featured')">
                                        @if ($coach->featured == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Yes')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('No')</span>
                                        @endif
                                    </td> --}}
                                    <td data-label="@lang('Action Availability')">
                                        <a href="{{ route('admin.coaches.schedule', $coach->user_code) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                        Add
                                        </a>
                                        &nbsp;
                                        <a href="{{ route('admin.coachavailabilityList.all', $coach->user_code) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                           Manage
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
                    {{ $coaches->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>


    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="{{ route('admin.availabilityCoach.all') }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
