@php
    $blog_content = getContent('lectures.content',true);
    $blog_element = \App\Frontend::where('data_keys', 'blog.element')->limit(3)->get();
    $sector_data = \App\DrYotube::Select('doctor_videos.*','doctors.name AS doctor')->join('doctors','doctors.id','doctor_videos.doctor_id')->latest()->get();
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
            @endforeach
        </div>
    </div>
</section>
<!-- blog-section end -->



