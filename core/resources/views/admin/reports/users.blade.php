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
                                <th scope="col">@lang('')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Type')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Mobile')</th>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('School')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Joined On')</th>
                                {{-- <th scope="col">@lang('Bio')</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td data-label="@lang('Author')">
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ asset(imagePath()["$user->user_type"]['path'].'/'. $user->profile_image,imagePath()["$user->user_type"]['size'])}}" alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Name')">{{ $user->first_name }} {{ $user->last_name }} </td>
                                        <td data-label="@lang('Type')">{{ ucfirst($user->user_type) }}</td>
                                        <td data-label="@lang('Email')">{{ $user->email }} </td>
                                        <td data-label="@lang('Mobile')">{{ $user->mobile_no }} </td>
                                        <td data-label="@lang('Title')">{{ $user->title }} </td>
                                        <td data-label="@lang('School')">{{ $user->school }} </td>
                                        <td data-label="@lang('Status')">
                                            @if($user->status)
                                                <span class="text--small badge font-weight-normal badge--success">Active</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Joined On')">{{ showDateTime($user->created_at) }}</td>                                    </tr>
                                        {{-- <td data-label="@lang('Bio')">{{ $user->bio }} </td> --}}
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
                    {{ $users->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form class="form-inline float-right" method="get">
        <label class="sr-only my-1 mr-2" for="from-date">Type</label>
        <select class="form-control form-control-sm mb-2 mr-sm-2" id="type" name="type">
            <option value="">All users</option>
            <option {{(request()->type == 'coach') ? 'selected': ''}} value="coach">Coaches</option>
            <option {{(request()->type == 'principal') ? 'selected': ''}} value="principal">Principals</option>
            <option {{(request()->type == 'author') ? 'selected': ''}} value="author">Authors</option>
        </select>
        
        <button type="submit" class="btn btn--primary box--shadow1 text--small addBtn mb-2 mr-2">@lang('Search')</button>
        <button type="submit" class="btn btn--primary box--shadow1 text--small addBtn mb-2" title="Export" name="action" value="export"><i class="fa fa-download"></i></button>
    </form>

    {{-- <a href="{{route('admin.admin.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a> --}}
@endpush
