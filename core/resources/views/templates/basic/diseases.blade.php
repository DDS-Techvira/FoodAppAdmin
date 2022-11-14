@extends($activeTemplate.'layouts.frontend')

@php
    $contact_us_content = getContent('contact_us.content',true);
    $contact_us_element = getContent('contact_us.element',false);
    $sector_data = \App\Disease::latest()->get();
@endphp

@section('content')
@include($activeTemplate.'partials.breadcrumb')

 <div class="row ptb-80 bgc1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <p style="">
                    The best approach to avoid contracting a sickness or to get cured of an infection is to first understand it. So we've taken it upon ourselves to educate you on nearly every known ailment, thereby protecting you as a true health-conscious soldier, and all you have to do is contact us.
                </p>
            </div>
        </div>
        <div class="row justify-content-center ptb-80">
            @foreach($sector_data as $item)
            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                <div class="card blog-item article-card article-card-h">
                    <div class="blog-thumb">
                        <img class="book-card-img" src="{{ getImage('assets/disease/'. @$item->image) }}" alt="@lang('blog-image')">
                        <span class="blog-cat">{{ __($item->name ) }}</span>
                    </div>
                    <div class=" card-body blog-content">
                        <h4 class="title"><a class="limit2" href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}">{{ Str::limit(strip_tags(__($item->article_title)),50) }} </a></h4>
                        <p class="limit5">{{ Str::limit(strip_tags(__($item->detail)),300) }}</p>
                        {{-- <div class="blog-btn">
                            <a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}" class="custom-btn">@lang('Continue Reading')</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>
 </div>

@endsection



