@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

@php
    $search_content = getContent('search.content',true);
    $locations = \App\Location::latest()->get(['id','name']);
    $sectors = \App\Sector::latest()->get(['id','name']);
    $doctors_all = \App\Doctor::latest()->get(['id','name']);
@endphp

<!-- booking-section start -->
<section class="booking-section ptb-80 bgc1">
    <div class="container">
        <div class="booking-search-area">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="appoint-content">
                        <form class="appoint-form mt-0 ml-b-20" action="{{ route('search.doctors') }}" method="get">
                            @csrf
                            <div class="search-location form-group">
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
                            </div>
                            <div class="search-info form-group">
                                <div class="appoint-select">
                                    <select class="chosen-select locations" name="doctor">
                                        <option value="">@lang('Doctor*')</option>
                                        @foreach ($doctors_all as $item)
                                            <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="search-btn cmn-btn"><i class="icon-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center ml-b-30">
            @forelse($doctors as $item)
                {{-- <div class="col-lg-3 col-md-6 col-sm-6 mrb-30">
                    <div class="booking-item">
                        <div class="booking-thumb">
                            <img src="{{getImage(imagePath()['doctor']['path'].'/'.$item->image,imagePath()['doctor']['size'])}}" alt="@lang('booking')">
                            <div class="doc-deg">{{ __($item->sector->name) }}</div>
                            <a href="#0" class="fav-btn"><i class="far fa-bookmark"></i></a>
                        </div>
                        <div class="booking-content">
                            <span class="sub-title"><a href="{{ route('sector.doctors.all',$item->sector->id) }}">{{ __($item->sector->name) }}</a></span>
                            <h5 class="title">{{ __($item->name) }} <i class="fas fa-check-circle"></i></h5>
                            <p>{{ Str::limit(__($item->qualification),50) }}</p>
                            <div class="booking-ratings">
                                @for ($i = 0; $i < $item->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <ul class="booking-list">
                                <li><i class="icon-direction-alt"></i><a href="{{ route('location.doctors.all',$item->location->id) }}">{{ __($item->location->name) }}</a></li>
                                <li><i class="las la-phone"></i> {{ __($item->mobile) }}</li>
                            </ul>
                            <div class="booking-btn">
                                <a href="{{ route('doctorDetails',$item->id) }}" class="cmn-btn">@lang('View Details')</a>
                                <a href="{{ route('booking',$item->id) }}" class="cmn-btn">@lang('Book Now')</a>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-3 mrb-30 ">
                    <div class="card doc-card m-2" >
                        <a href="{{ route('doctorDetails',$item->id) }}" >  <img class="card-img-top doc-card-img" src="{{getImage(imagePath()['doctor']['path'].'/'.$item->image,imagePath()['doctor']['size'])}}" alt="@lang('doctor-image')" alt="Card image cap"></a>

                        <div class="card-body">
                        <a href="{{ route('doctorDetails',$item->id) }}" ><p class="card-text text-center line-space-1" style="margin-bottom: 0px;">{{ __($item->name) }}</p></a>
                          {{-- <p class="card-text text-center" style="margin-bottom: 0px;">{{ __($item->name) }}</p> --}}
                          <p class="text-secondary text-center " style="margin-top: 0px; font-size:11px;">{{ Str::limit(__($item->qualification),70)}}</p>
                          
                        </div>
                        <div class="text-center card-footer booking-btn">

                            <a href="{{ route('doctorDetails',$item->id) }}" class="cmn-btn" style="font-size: 13px"> <span><i class="fa fa-book" aria-hidden="true"></i> </span> View</a>
                            <a href="{{ route('booking',$item->id) }}" class="cmn-btn" style="font-size: 13px"> <span><i class="fa fa-calendar-check" aria-hidden="true"></i> </span> Channel</a>
                            {{-- <a href="{{ route('doctorDetails',$item->id) }}" class="cmn-btn">@lang('View Details')</a> --}}

                        </div>

                    </div>
                </div>

            @empty
                <div class="col-lg-12 col-md-12 col-sm-12 mrb-30">
                    <div class="booking-item text-center">
                        <h3 class="title">@lang('Sorry! No Doctor Found')</h3>
                        <div class="booking-btn mt-4">
                            <a href="javascript:window.history.back();" class="cmn-btn">@lang('Go Back')</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        {{ $doctors->links() }}
    </div>
</section>
<!-- booking-section end -->
@endsection
