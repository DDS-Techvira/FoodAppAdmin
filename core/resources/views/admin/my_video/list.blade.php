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
                                <th scope="col">@lang('Preview')</th>
                                <th scope="col">@lang('Video')</th>
                                <th scope="col">@lang('Created On')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($videos as $video)
                                    <tr>
                                        <td data-label="@lang('Preview')">
                                            <div class="user">
                                                <div><img src="{{$video['pictures']['base_link']}}" height="100px" width="100px" alt="tag"></div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Video')"><a target="_blank" href="{{ $video['link'] }}">{{ $video['name'] }}</a></td>
                                        <td data-label="@lang('Created On')">{{ showDateTime($video['created_time']) }}</td>
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
                    {{-- {{ $videos->links('admin.partials.paginate') }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.my_video.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
