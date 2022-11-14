@php
$blog_content = getContent('latest-articles.content', true);
$blog_element = \App\Frontend::where('data_keys', 'blog.element')
    ->limit(3)
    ->get();
$sector_data = \App\DrArticles::Select('doctor_articles.*', 'doctors.name AS doctor')
    ->join('doctors', 'doctors.id', 'doctor_articles.doctor_id')
    ->limit(10)
    ->get();
@endphp
<!-- blog-section start -->

<section class="blog-section ptb-80 bgc1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __($blog_content->data_values->heading) }}</h2>
                    {{-- <p>{{ __($blog_content->data_values->details) }}</p> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="booking-slider">
                <div class="swiper-wrapper">
                    @foreach ($sector_data as $item)
                        <div class="swiper-slide">
                            <div class="booking-item article-card last-art-h">
                                <div class="booking-thumb text-center">
                                    <img src="{{ getImage('assets/articles/' . @$item->article_image) }}"
                                        alt="@lang('blog-image')">
                                    <span class="blog-cat">{{ __($item->doctor) }}</span>

                                </div>
                                <div class="booking-content text-center">

                                    <h5 class="title">{{ __($item->name) }} </h5>
                                    <p>{{ Str::limit(strip_tags(__($item->article_description)), 100) }}</p>

                                    <div class="blog-btn">
                                        <a href="{{ route('blog.details', [$item->id, \Str::slug(__($item->id))]) }}"
                                            class="custom-btn">@lang('Continue Reading')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="ruddra-next">
                    <i class="fas fa-long-arrow-alt-right"></i>
                </div>
                <div class="ruddra-prev">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </div>
            </div>
        </div>
        {{-- <div class="row justify-content-center">
            @foreach ($sector_data as $item)
            <div class="col-lg-3 col-md-6 col-sm-8 mrb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <img src="{{ getImage('assets/articles/'. @$item->article_image) }}" alt="@lang('blog-image')">
                        <span class="blog-cat">{{ __($item->doctor ) }}</span>
                    </div>
                    <div class="blog-content">
                        <h4 class="title"><a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}">{{ Str::limit(strip_tags(__($item->article_title)),50) }} </a></h4>
                        <p>{{ Str::limit(strip_tags(__($item->article_description)),100) }}</p>
                        <div class="blog-btn">
                            <a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}" class="custom-btn">@lang('Continue Reading')</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div> --}}
        <div class="row justify-content-center mrt-60">
            <div class="col-lg-12 text-center">
                <div class="team-btn">
                    <a href="/articles-all" class="cmn-btn">@lang('View More')</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- blog-section end -->
