@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
echo fbcomment();
$lectures_data = \App\DrYotube::Select('doctor_videos.*','doctors.name AS doctor')->where('doctor_videos.doctor_id',$doctor->id)->join('doctors','doctors.id','doctor_videos.doctor_id')->latest()->get();
$articles_data = \App\DrArticles::Select('doctor_articles.*','doctors.name AS doctor')->where('doctor_articles.doctor_id',$doctor->id)->join('doctors','doctors.id','doctor_articles.doctor_id')->latest()->get();
 @endphp
<!-- booking-section start -->
@include($activeTemplate.'partials.breadcrumb')
<section class="booking-section booking-section-two pd-t-80 pd-b-40 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="booking-item d-flex flex-wrap align-items-center justify-content-between mb-5">
                    <div class="booking-left d-flex align-items-center">
                        <div class="booking-thumb">
                            <img src="{{getImage(imagePath()['doctor']['path'].'/'.$doctor->image,imagePath()['doctor']['size'])}}" alt="@lang('doctor')">
                            <a href="#0" class="fav-btn"><i class="far fa-bookmark"></i></a>
                        </div>
                        <div class="booking-content">
                            <span class="sub-title"><a href="#0">{{ __($doctor->sector->name) }}</a></span>
                            <h5 class="title">{{ __($doctor->name) }} <i class="fas fa-check-circle"></i></h5>
                            <p>{{ __($doctor->qualification) }}</p>
                            <div class="booking-ratings">
                                @for ($i = 0; $i < $doctor->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <ul class="booking-list">
                                {{-- <li><i class="icon-direction-alt"></i>{{ __($doctor->location->name) }}</li> --}}
                                {{-- <li><i class="las la-phone"></i> {{ __($doctor->mobile) }}</li> --}}
                            </ul>
                            @if ($doctor->speciality != null || !empty($doctor->speciality))
                                <div class="booking-btn">
                                    @foreach ($doctor->speciality as $item)
                                        <a href="#0" class="border-btn">{{ __($item) }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="booking-right">
                        <div class="booking-content">
                            <ul class="booking-list">
                                <li><i class="fas fa-hourglass-start"></i>@lang('Joined us') :</li>
                                <li><i class="fas fa-stethoscope"></i>{{ diffForHumans($doctor->created_at) }}</li>
                                {{-- <li><span><i class="fas fa-wallet"></i>@lang('Fees') : {{__($general->cur_sym)}} {{ __($doctor->fees) }} <span></li> --}}
                            </ul>
                            <ul class="booking-tag">
                                @foreach ($doctor->socialIcons as $item)
                                    <li><a href="{{ $item->url }}" target="_blank">@php echo $item->icon @endphp</a></li>
                                @endforeach
                            </ul>
                            <div class="booking-btn">
                                @if($doctor->serial_day > 0 && $doctor->serial_or_slot != null)
                                    <a href="#0" class="border-btn active">@lang('Appointment Available')</a>
                                    <div class="booking-btn">
                                        <a href="{{ route('booking',$doctor->id) }}" class="cmn-btn">@lang('Book Now')</a>
                                    </div>
                                @else
                                    <a href="#0" class="border-btn active">@lang('Appointment Unavailable')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- booking-section end -->

<!-- overview-section start -->
<section class="overview-section pd-b-80">
    <div class="container">
        <div class="overview-area mrb-40">
            <div class="row">
                <div class="col-lg-12">
                    <div class="overview-tab-wrapper">
                        <ul class="tab-menu">
                            <li>@lang('Overview')</li>
                            <li class="active">@lang('Articles')</li>
                            <li>@lang('Lectures')</li>
                        </ul>
                        <div class="tab-cont">
                            <div class="tab-item">
                                <div class="overview-tab-content ml-b-30">
                                    <div class="overview-content">
                                        <h5 class="title">@lang('About Me')</h5>
                                        <p>{{ __($doctor->about) }}</p>
                                    </div>
                                    <div class="overview-content">
                                        <h5 class="title">@lang('Education')</h5>
                                        <div class="overview-box">
                                            <ul class="overview-list">
                                                @foreach($doctor->educationDetails as $item)
                                                    <li>
                                                        <div class="overview-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="overview-details">
                                                            <h6 class="title">{{ __($item->institution) }}</h6>
                                                            <div>{{ __($item->discipline) }}</div>
                                                            <span>{{ __($item->period) }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="overview-content">
                                        <h5 class="title">@lang('Work & Experience')</h5>
                                        <div class="overview-box">
                                            <ul class="overview-list">
                                                @foreach($doctor->experienceDetails as $item)
                                                    <li>
                                                        <div class="overview-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="overview-details">
                                                            <h6 class="title">{{ __($item->institution) }}</h6>
                                                            <div>{{ __($item->discipline) }}</div>
                                                            <span>{{ __($item->period) }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="overview-content">
                                        <h5 class="title">@lang('Specializations')</h5>
                                        <div class="overview-footer-area d-flex flex-wrap justify-content-between">
                                            <ul class="overview-footer-list">
                                                @if($doctor->speciality != null || !empty($doctor->speciality))
                                                    @foreach ($doctor->speciality as $item)
                                                        <li><i class="fas fa-long-arrow-alt-right"></i>{{ __($item) }}</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-item">
                                <div class="overview-tab-content">

                                    <div class="row justify-content-center">
                                        @foreach($articles_data as $item)
                                        <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                                            <div class="blog-item">
                                                <div class="blog-thumb">
                                                    <img src="{{ getImage('assets/articles/'. @$item->article_image) }}" alt="@lang('blog-image')">
                                                    <span class="blog-cat">{{ __($item->doctor ) }}</span>
                                                </div>
                                                <div class="blog-content">
                                                    <h4 class="title"><a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}">{{ Str::limit(strip_tags(__($item->article_title)),50) }} </a></h4>
                                                    <p>{{ Str::limit(strip_tags(__($item->article_description)),300) }}</p>
                                                    <div class="blog-btn">
                                                        <a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}" class="custom-btn">@lang('Continue Reading')</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-item">
                                <div class="row justify-content-center">
                                    @foreach($lectures_data as $item)
                                    <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                                        <div class="blog-item">
                                            <div class="blog-thumb">
                                                <iframe height="250" width="370"  src="{{$item->youtube_link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                <span class="blog-cat">{{ __($item->doctor ) }}</span>
                                            </div>

                                            <div class="blog-content">
                                                <h4 class="title"><a href="{{ route('blog.details',[$item->id,\Str::slug(__($item->article_title))]) }}">{{ Str::limit(strip_tags(__($item->title)),50) }} </a></h4>
                                                <p>{{ Str::limit(strip_tags(__($item->description)),300) }}</p>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- overview-section end -->
@endsection

@push('script')
<script>

    (function ($) {
        'use strict';

        $(document).on('click', '.active-time ', function(){
            $('.time').val($(this).data('value'));
            $('#book-time').text($(this).data('value'));
        });




        var booking = $('select[name=booking_date]').find('option:selected').val();
        $('.available-time').removeClass('active');
        var date = $('#date').text(booking);

        var url = "{{route('bookeddate')}}";
        var date = booking;
        var id = '<?php echo $doctor->id; ?>';
        var data = {date:date,doctor_id:id}

        $.get(url, data,function(response){
            $('.time').val('');
            if(response.length == 0){
                $('.available-time').removeClass('disabled').addClass('active-time');
            }else{
                $('.available-time').removeClass('disabled').addClass('active-time');
                $.each(response, function(key, value) {
                    var item = $(`.item${value}`);
                    item.addClass('disabled').removeClass('active-time');
                });
            }
        });





        $('select[name=booking_date]').on('change',function(){
            $('.available-time').removeClass('active');
            var date = $('#date').text($(this).val());

            var url = "{{route('bookeddate')}}";
            var date = $(this).val();
            var id = '<?php echo $doctor->id; ?>';
            var data = {date:date,doctor_id:id}

            $.get(url, data,function(response){
                $('.time').val('');
                if(response.length == 0){
                    $('.available-time').removeClass('disabled').addClass('active-time');
                }else{
                    $('.available-time').removeClass('disabled').addClass('active-time');
                    $.each(response, function(key, value) {
                        var item = $(`.item${value}`);
                        item.addClass('disabled').removeClass('active-time');
                    });
                }
            });
        });







        $(document).on('click', '.payment-system', function(){
            $('.payment').val($(this).data('value'));
        });

        $(document).on('input','[name=name]',function() {
            $('#name').text($(this).val());
        });
        $(document).on('input','[name=age]',function() {
            $('#age').text($(this).val());
        });
        $(document).on('input','[name=email]',function() {
            $('#email').text($(this).val());
        });
        $(document).on('input','[name=mobile]',function() {
            $('#mobile').text($(this).val());
        });

        $(document).on('click', '.reset ', function(){
            $('#name').text('');
            $('#age').text('');
            $('#email').text('');
            $('#mobile').text('');
            $('#book-time').text('');

            $('.available-time').removeClass('active');
            $('.time').val('');

            $('.appointment-from').trigger("reset");

        });
    })(jQuery);
</script>
@endpush
