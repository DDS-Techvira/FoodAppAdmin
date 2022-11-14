@php
    $sector_content = getContent('category.content',true);
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
<section class="booking-section bgc1 ptb-80">
    <div class="container" >
        <div class="row ">
            {{-- <div class="booking-right-area"> --}}
                <div class="col-lg-12 col-md-12">
                    <div class="section-header">
                        <h2 class="section-title text-center">{{ __($sector_content->data_values->heading) }}</h2>
                        <p class="m-0 text-center">{{ __($sector_content->data_values->details) }}</p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="booking-slider">
                        <div class="swiper-wrapper">
                            @foreach ($sector_data as $item)
                                <div class="swiper-slide">
                                    <div class="booking-item">
                                        <div class="booking-thumb text-center">
                                            <img style="width: 5rem;height:5rem;" src="{{getImage(imagePath()['sector']['path'].'/'.$item->image,imagePath()['sector']['size'])}}" alt="@lang('sector')">
                                            {{-- <div class="doc-deg">{{ __($item->sector->name) }}</div> --}}
                                            {{-- <a href="#0" class="fav-btn"><i class="far fa-bookmark"></i></a> --}}
                                        </div>
                                        <div class="booking-content text-center">
                                            {{-- <span class="sub-title"><a href="{{ route('sector.doctors.all',$item->sector->id) }}">{{ __($item->sector->name) }}</a></span> --}}
                                            <h5 class="title">{{ __($item->name) }} </h5>
                                            {{-- <p>{{ Str::limit(__($item->qualification),50) }}</p> --}}
                                            {{-- <div class="booking-ratings">
                                                @for ($i = 0; $i < $item->rating; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                            </div> --}}
                                            {{-- <ul class="booking-list">
                                                <li><i class="icon-direction-alt"></i><a href="{{ route('location.doctors.all',$item->location->id) }}">{{ __($item->location->name) }}</a></li>
                                                <li><i class="las la-phone"></i> {{ __($item->mobile) }}</li>
                                            </ul> --}}
                                            <div class="booking-btn">
                                                {{-- <a href="{{ route('booking',$item->id) }}" class="cmn-btn">@lang('View')</a> --}}
                                                <form class="appoint-form mt-0 ml-b-20" action="{{ route('search.doctors') }}" method="get">
                                                    @csrf
                                                    {{-- <div class="search-location form-group">
                                                        <div class="appoint-select">
                                                            <select class="chosen-select locations" name="location">
                                                                <option value="">@lang('Location*')</option>
                                                                @foreach ($locations as $item)
                                                                    <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="search-location form-group">
                                                        <div class="appoint-select">
                                                            <select class="chosen-select locations" name="sector">
                                                                <option value="">@lang('Sector*')</option>
                                                                @foreach ($sectors as $item)
                                                                    <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="search-info form-group">
                                                        <div class="appoint-select" >
                                                            <select class="chosen-select locations" id="category" name="category" onselect="">
                                                                <option value="" >@lang('Sector*')</option>
                                                                @foreach ($sectors as $item)
                                                                    <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    <input name="category" value="{{ $item->id }}" hidden>
                                                    <button type="submit" class="search-btn cmn-btn">@lang('View More')</button>
                                                </form>
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
            {{-- </div> --}}
        </div>
    </div>
</section>
<!-- choose-section end -->
