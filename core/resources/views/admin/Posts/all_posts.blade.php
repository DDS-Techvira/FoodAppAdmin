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
                                <th scope="col">@lang('Id')</th>
                                <th scope="col">@lang('Article Image')</th>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Author')</th>
                                <th scope="col">@lang('Created Date')</th>
                                <th scope="col">@lang('Published')</th>
                                <th scope="col">@lang('Daily Dose')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($articles as $article)
                                <tr>
                                <td data-label="@lang('Email')">{{ $article->id }}</td>
                                    <td data-label="@lang('article')">
                                        <div class="user">
                                            <div>
                                                <img src="{{asset('assets/posts/'.$article->post_image )}}" height="100px" width="100px" alt="tag">
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Username')"><a href="{{ route('admin.posts.detail', $article->id) }}">{{ $article->title  }}</a></td>
                                    <td data-label="@lang('Email')">{{ $article->name }}</td>
                                    <td data-label="@lang('Total Earn')">{{ $article->author_name }}</td>
                                    <td data-label="@lang('Joined On')">{{ showDateTime($article->created_at) }}</td>
                                    <td data-label="@lang('Featured')">
                                        @if ($article->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Yes')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('No')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Daily Dose')">
                                        @if ($article->is_daily_dose == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Yes')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('No')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.posts.detail', $article->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
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
                    {{ $articles->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.posts.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
    <!-- <form action="{{ route('admin.posts.search', $scope ?? str_replace('admin.posts.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form> -->
@endpush
