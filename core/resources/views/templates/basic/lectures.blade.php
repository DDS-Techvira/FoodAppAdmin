@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

@php
    // $search_content = getContent('search.content',true);
    // $locations = \App\Location::latest()->get(['id','name']);
    // $sectors = \App\Sector::latest()->get(['id','name']);
    // $doctors_all = \App\Doctor::latest()->get(['id','name']);
    $blog_content = getContent('lectures.content',true);
    $blog_element = \App\Frontend::where('data_keys', 'blog.element')->limit(3)->get();
    $sector_data = \App\DrYotube::Select('doctor_videos.*','doctors.name AS doctor')->join('doctors','doctors.id','doctor_videos.doctor_id')->latest()->get();
@endphp

<!-- booking-section start -->
<section class="booking-section ptb-80 bgc1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __($blog_content->data_values->heading) }}</h2>
                    <p>{{ __($blog_content->data_values->details) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center ml-b-30">
            @forelse($lectures as $item)


            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                <div class="booking-item article-card">
                    <div class="booking-thumb text-center">
                        <iframe height="250" width="100%"  src="{{$item->youtube_link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <br>
                        <br>
                        <span class="blog-cat">{{ __($item->doctor ) }}</span>
                    </div>

                    <div class="booking-content text-center">
                        <h4 class="title"><a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}">{{ Str::limit(strip_tags(__($item->title)),25) }} </a></h4>
                        <p>{{ Str::limit(strip_tags(__($item->description)),300) }}</p>

                    </div>
                </div>
            </div>

            @empty
                <div class="col-lg-12 col-md-12 col-sm-12 mrb-30">
                    <div class="booking-item text-center">
                        <h3 class="title">@lang('Sorry! No Lectures Found')</h3>
                        <div class="booking-btn mt-4">
                            <a href="javascript:window.history.back();" class="cmn-btn">@lang('Go Back')</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        {{ $lectures->links() }}
    </div>
</section>
<!-- booking-section end -->
@endsection
