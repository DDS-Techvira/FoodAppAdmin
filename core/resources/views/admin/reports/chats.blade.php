@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->total_users, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Total Principals</p>
              </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->chats, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Total Chats</p>
              </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->closed, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Closed Chats</p>
              </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center mb-4">
              <div class="card-body">
                <h1 class="card-title mb-0">{{str_pad($summery->ongoing, 2, '0', STR_PAD_LEFT)}}</h1>
              </div>
              <div class="card-footer text-muted">
                <p>Ongoing Chats</p>
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
                                <th scope="col">@lang('Topic')</th>
                                <th scope="col">@lang('Chat Start')</th>
                                <th scope="col">@lang('Chat End')</th>
                                <th scope="col">@lang('Chat Duration')</th>
                                <th scope="col">@lang('Status')</th>
                                {{-- <th scope="col">@lang('Featured')</th> --}}
                                <!-- <th scope="col">@lang('Action')</th> -->
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($chats as $chat)
                                    <tr>
                                        <td data-label="@lang('Author')">
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ asset(imagePath()['principal']['path'].'/'. $chat->profile_image,imagePath()['principal']['size'])}}" alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Principal Name')">{{ $chat->principal_first_name }} {{ $chat->principal_last_name }} </td>
                                        <td data-label="@lang('Coach Name')">{{ $chat->coach_first_name }} {{ $chat->coach_last_name }} </td>
                                        <td data-label="@lang('Topic')"><?= wordwrap($chat->topic, 40, "<br>\n") ?></td>
                                        <td data-label="@lang('Chat Start')">{{ showDateTime($chat->created_at) }}</td>
                                        <td data-label="@lang('Chat End')">{{ showDateTime($chat->updated_at) }}</td>
                                        <td data-label="@lang('Chat Duration')">{{ str_replace('before', '', diffDatesForHumans($chat->created_at, $chat->updated_at)) }}</td>
                                        <td data-label="@lang('Status')">
                                            @if ($chat->status == 0 && empty($chat->coach_code))
                                                <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                            @elseif ($chat->status == 0)
                                                <span class="text--small badge font-weight-normal badge--dark">@lang('Ongoing')</span>
                                            @elseif ($chat->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Complete')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--secondary">@lang('Incomplete')</span>
                                            @endif
                                        </td>
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
                    {{ $chats->links('admin.partials.paginate') }}
                </div>
            </div>
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

    {{-- <a href="{{route('admin.admin.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a> --}}
@endpush
