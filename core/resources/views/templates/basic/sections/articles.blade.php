@php
    $blog_content = getContent('articles.content',true);
    $blog_element = \App\Frontend::where('data_keys', 'blog.element')->limit(3)->get();
    $sector_data = \App\DrArticles::Select('doctor_articles.*','doctors.name AS doctor')->join('doctors','doctors.id','doctor_articles.doctor_id')->latest()->get();
@endphp
<!-- blog-section start -->
<section class="blog-section ptb-80 bgc1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __($blog_content->data_values->heading) }}</h2>
                    <p>{{ __($blog_content->data_values->details) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($sector_data as $item)
            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                <div class="booking-item article-card article-card-h">
                    <div class="booking-thumb text-center">
                        <img src="{{ getImage('assets/articles/'. @$item->article_image) }}" alt="@lang('blog-image')">
                        <br>
                        <br>
                        <span class="blog-cat">{{ __($item->doctor ) }}</span>
                    </div>
                    <div class="booking-content text-center">
                        <h4 class="title "><a class="limit2" href="{{ route('blog.details',[$item->id,\Str::slug(__($item->id))]) }}">{{ Str::limit(strip_tags(__($item->article_title)),50) }} </a></h4>
                        <p class="limit5">{{ Str::limit(strip_tags(__($item->article_description)),200) }}</p>
                        <div class="blog-btn">
                            <a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}" class="custom-btn">@lang('Continue Reading')</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- blog-section end -->


