@php
    $testimonial_content = getContent('testimonial-videos.content',true);
    $testimonial_element = getContent('testimonial-videos.element',false);
@endphp
<!-- client-section start -->
<div class="client-section ptb-80">
    <div class="client-element-one">
        <img src="{{ getImage('assets/images/shape.png') }}" alt="@lang('shape')">
    </div>
    <div class="client-element-two">
        <img src="{{ getImage('assets/images/shape.png') }}" alt="@lang('shape')">
    </div>
    <div class="container">
        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                    <div class="section-header-left">
                        <h2 class="section-title">{{ __($testimonial_content->data_values->heading) }}</h2>
                        <p class="m-0">{{ __($testimonial_content->data_values->details) }} </p>
                    </div>
                </div>
            </div>
        </div> --}}
            <div class="col-lg-12 col-md-12">

                <div class="booking-slider search-slider2 swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach ($testimonial_element as $item)
                            <div class="swiper-slide">
                                <div class="booking-item  ">
                                <div class=" text-center">
                                    <div class="">
                                        <div class="fb-post" data-href="https://www.facebook.com/explorehealth.lk/videos/{{@$item->data_values->facebook_Video_Id}}" data-width="auto" data-show-text="false"><blockquote cite="https://www.facebook.com/explorehealth.lk/videos/{{@$item->data_values->facebook_Video_Id}}" class="fb-xfbml-parse-ignore"></blockquote></div>
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






                {{-- <div class="booking-slider search-slider2 swiper-container-horizontal">
                <div class="swiper-wrapper">
                <div class="swiper-slide ">
                    <div class="booking-item article-card home-lec-h">
                        <div class="booking-thumb text-center">
                            @foreach ($testimonial_element as $item)
                            <div class="gimg">
                            <div class="fb-post" data-href="https://www.facebook.com/explorehealth.lk/videos/{{@$item->data_values->facebook_Video_Id}}" data-width="350" data-show-text="false"><blockquote cite="https://www.facebook.com/explorehealth.lk/videos/{{@$item->data_values->facebook_Video_Id}}" class="fb-xfbml-parse-ignore"></blockquote></div>
                            </div>
                            @endforeach
                        </div>


                    </div>
                </div>
                </div>
                </div> --}}
            </div>
    </div>
</div>
@push('script')
<script>
    window.fbAsyncInit = function() {
      FB.init({
        appId            : 'your-app-id',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v11.0'
      });
    };
  </script>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
  @endpush
