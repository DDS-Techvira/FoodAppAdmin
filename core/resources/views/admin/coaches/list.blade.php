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
                                <th scope="col">@lang('Joined On')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($doctors as $doctor)
                                <tr>
                                    <td data-label="@lang('Coach')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ asset(imagePath()['coach']['path'].'/'. $doctor->profile_image,imagePath()['coach']['size'])}}" alt="@lang('image')"></div>
                                            <span class="name">{{$doctor->name}}</span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Username')"><a href="{{ route('admin.coaches.detail', $doctor->id) }}">{{ $doctor->first_name }} {{ $doctor->last_name }}</a></td>
                                    <td data-label="@lang('Email')">{{ $doctor->email }}</td>
                                    <td data-label="@lang('Email')">{{ $doctor->mobile_no }}</td>
                                    <td data-label="@lang('Joined On')">{{ showDateTime($doctor->created_at) }}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.coaches.detail', $doctor->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                            <i class="las la-pencil-alt text--shadow"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($empty_message)}}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $doctors->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
