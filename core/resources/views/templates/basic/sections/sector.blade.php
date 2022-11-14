@php
    $sector_content = getContent('sector.content',true);
    $sector_data = \App\Sector::latest()->get();

    if($sector_data->count() >= 4){
        $len = round($sector_data->count() / 4);
    }else{
        $len = $sector_data->count();
    }
    $item = [];
    $skip = 0;
    for($i = 0; $i<$len; $i++) {
        $item[$i] = $sector_data->skip($skip)->take(4);
        $skip += 4;
    }
@endphp

<!-- choose-section start -->
<section class="choose-section ptb-80 bgc1">
    <div class="container">
        <div class="row justify-content-center align-items-center ">
            <div class="col-lg-12 col-md-12 ">
                <div class="choose-left-content">
                    <h1 class="title text-center">{{ __($sector_content->data_values->heading) }}</h1>
                    <p class="text-center">{{ __($sector_content->data_values->details) }}</p>
                    {{-- <div class="choose-btn">
                        <a href="{{ route('doctors.all') }}" class="cmn-btn">@lang('Book Now')</a>
                    </div> --}}
                </div>
            </div>
            {{-- <div class="col-lg-8 mrb-30">
                <div class="choose-slider">
                    <div class="swiper-wrapper">
                        @for($j = 0; $j < count($item); $j++)
                        <div class="swiper-slide">
                            <div class="choose-right-content">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="right-column-one">
                                            @foreach($item[$j]->take(2) as $data)
                                            <div class="choose-item">
                                                <div class="choose-thumb">
                                                    <img src="{{getImage(imagePath()['sector']['path'].'/'.$data->image,imagePath()['sector']['size'])}}" alt="@lang('choose')">
                                                </div>
                                                <div class="choose-content">
                                                <h6 class="title"><a href="{{ route('sector.doctors.all',$data->id) }}">{{ __($data->name) }}</a></h6>
                                                    <p>{{ __($data->details) }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="right-column-two">
                                            @foreach($item[$j]->skip(2)->take(2) as $data)
                                            <div class="choose-item">
                                                <div class="choose-thumb">
                                                    <img src="{{getImage(imagePath()['sector']['path'].'/'.$data->image,imagePath()['sector']['size'])}}" alt="@lang('choose')">
                                                </div>
                                                <div class="choose-content">
                                                <h6 class="title">{{ __($data->name) }}</h6>
                                                    <p>{{ __($data->details) }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div> --}}
        </div>
        <div class="row ptb-80" style="padding-bottom: 0px;">
            <div class="col-md-5 col-lg-5">
                <img src="{{ asset('/assets/images/mockup.png')}}" alt="">
            </div>
            <div class="col-md-7 col-lg-7 pd-t-80">
                <h1 class="section-title" style="font-size: 50px; margin-bottom:25px;">Simply channel a doctor in three taps!</h1>
                <p style="margin-bottom:30px;">Avoid traffic, crowded hospital waiting rooms, and pathogen exposure by consulting a doctor from the convenience of your own home.
                </p>
                <a href="/getapp" class="cmn-btn">Download Explore Health</a>
            </div>
        </div>
    </div>
</section>
<!-- choose-section end -->
