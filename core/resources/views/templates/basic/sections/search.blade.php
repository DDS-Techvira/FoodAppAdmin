@php
    $search_content = getContent('search.content',true);
    $locations = \App\Location::latest()->get(['id','name']);
    $sectors = \App\Sector::latest()->get(['id','name']);
    $doctors_all = \App\Doctor::latest()->get(['id','name']);
    $feature_content = getContent('feature.content',true);
    $doctors = \App\Doctor::where('status',1)->where('featured',1)->with('sector:id,name')->with('location:id,name')->with(['socialIcons' => function($query) {
        $query->select(['id','url','icon','doctor_id']);
    }])->latest()->take(6)->get(['id','name','about','qualification','sector_id','location_id','image','mobile']);
@endphp
<!-- appoint-section start -->
<section class="booking-section ptb-80 bgc2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-header">
                    <h2 class="section-title text-center">{{ __($feature_content->data_values->heading) }}</h2>
                    <p class=" text-center">{{ __($feature_content->data_values->details) }} </p>
                </div>
            </div>
        </div>
        <div class="booking-search-area">
            <div class="row justify-content-left">
                <div class="col-lg-12 text-left">
                    <div class="appoint-content">
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
                            <div class="search-info form-group">
                                <div class="appoint-select" >
                                    <select class="chosen-select locations" id="category" name="category" onselect="">
                                        <option value= >@lang('All*')</option>
                                        @foreach ($sectors as $item)
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
         <div class="box-header" style="min-height: 50vh;" id="user_reference_suggestion">
        <div class="container" id="doctor_sector">
            <h2 class="text-center">Doctors</h2>
            <br>
            <div class="row">

                <div class="col-lg-12 col-md-12">

                <div class="booking-slider ">


                    <div class="swiper-wrapper">

                @foreach($doctors as $item)
                <div class="swiper-slide">

                        <div class="card doc-card " >
                            <a href="{{ route('doctorDetails',$item->id) }}" >  <img class="card-img-top doc-card-img" src="{{getImage(imagePath()['doctor']['path'].'/'.$item->image,imagePath()['doctor']['size'])}}" alt="@lang('doctor-image')" alt="Card image cap"></a>

                            <div class="card-body">
                            <a href="{{ route('doctorDetails',$item->id) }}" ><p class="card-text text-center line-space-1" style="margin-bottom: 0px;">{{ __($item->name) }}</p></a>

                              <p class="text-secondary text-center " style="margin-top: 0px; font-size:11px;">{{ Str::limit(__($item->qualification),70)}}</p>

                            </div>
                            <div class="text-center card-footer booking-btn">

                                <a href="{{ route('doctorDetails',$item->id) }}" class="cmn-btn" style="font-size: 13px"> <span><i class="fa fa-book" aria-hidden="true"></i> </span> View</a>
                                <a href="{{ route('booking',$item->id) }}" class="cmn-btn" style="font-size: 13px"> <span><i class="fa fa-calendar-check" aria-hidden="true"></i> </span> Channel</a>

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




            </div>
            <div class="row justify-content-center mrt-60">
                <div class="col-lg-12 text-center">
                    <div class="team-btn">
                        <a href="{{ route('featured.doctors.all') }}" class="cmn-btn">@lang('View More')</a>
                    </div>
                </div>
            </div>
        </div>





        <div class="container" id="doctor_sector0">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-12 col-md-12">
                    <h2 class="text-center">Doctors</h2>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="booking-slider search-slider1">
                        <div class="swiper-wrapper" id="demo">

                        </div>
                        <div class="ruddra-next">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                        <div class="ruddra-prev">
                            <i class="fas fa-long-arrow-alt-left"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mrt-60">
                <div class="col-lg-12 text-center">
                    <div class="team-btn">
                        <a href="{{ route('featured.doctors.all') }}" class="cmn-btn">@lang('View More')</a>
                    </div>
                </div>
            </div>
        {{-- <div class="divider"></div> --}}
        <hr>
        </div>

&nbsp;
&nbsp;
&nbsp;
&nbsp;
            <div class="container" style="display: none" id="datanot" >
                <div class="row justify-content-center ml-b-30">
                    <div class="col-lg-12 col-md-12">
                        <h2 class="text-center">Data Not Found!</h2>
                    </div>
                </div>
            </div>

        <div class="container" id="doctor_sector1" >
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-12 col-md-12">
                    <h2 class="text-center">Articles</h2>
                </div>
            </div>
            <br>
            <br>
            <div class="row ">
                <div class="col-lg-12 col-md-12">
                    <div class="booking-slider search-slider1">
                        <div class="swiper-wrapper " id="demo1">

                        </div>
                        <div class="ruddra-next">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                        <div class="ruddra-prev">
                            <i class="fas fa-long-arrow-alt-left"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mrt-60">
                <div class="col-lg-12 text-center">
                    <div class="team-btn">
                        <a href="{{ route('pages','articles-all') }}" class="cmn-btn">@lang('View More')</a>
                    </div>
                </div>
            </div>
            {{-- <div class="divider"></div> --}}
            <hr>
        </div>
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
        <div class="container" id="doctor_sector2" >
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-12 col-md-12">
                    <h2 class="text-center">Lectures</h2>
                </div>
            </div>
            <br>
            <br>
            <div class="row ">
                <div class="col-lg-12 col-md-12">
                    <div class="booking-slider search-slider2">
                        <div class="swiper-wrapper" id="demo2">

                        </div>
                        <div class="ruddra-next">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                        <div class="ruddra-prev">
                            <i class="fas fa-long-arrow-alt-left"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mrt-60">
                <div class="col-lg-12 text-center">
                    <div class="team-btn">
                        <a href="{{ route('pages','lectures-all') }}" class="cmn-btn">@lang('View More')</a>
                    </div>
                </div>
            </div>
        </div>


    </div>


</section>

@push('script')
    <!-- main -->
    <script>


        (function ($) {
            "use strict";
            // $(document).ready(function(){
            //     alert('Neww');
            //     });

                var d0 = document.getElementById("doctor_sector0");
                var d1 = document.getElementById("doctor_sector1");
                var d2 = document.getElementById("doctor_sector2");


                d0.style.display = "none";
                d1.style.display = "none";
                d2.style.display = "none";




                $('select').on('change', function() {

                    var x = document.getElementById("doctor_sector");
                    x.style.display = "none";


                    // var y = document.getElementById("demo1");
                    // y.style.display = "none";
                    // var z = document.getElementById("demo2");
                    // z.style.display = "none";
                    $.ajax({
                url: 'all/sector/'+this.value,
                type: 'get',
                processData: false,
                dataType: "json",
                contentType: false,
                beforeSend: function () {

                },
                error: function() {
                        // alert('Error occurs!');
                    },
                complete: function(data){
                    // document.getElementById("doc-s")
                    // $(".doc-s").addClass('swiper-slide');

                    console.log(data);

                    var swiper = new Swiper('.search-slider1', {
                    slidesPerView: 4,
                    spaceBetween: 30,
                    loop: false,
                    navigation: {
                        nextEl: '.ruddra-next',
                        prevEl: '.ruddra-prev',
                    },
                    autoplay: {
                        speeds: 1000,
                        delay: 2000,
                    },
                    speed: 1000,
                    breakpoints: {
                        1400: {
                        slidesPerView: 4,
                        },
                        1199: {
                        slidesPerView: 3,
                        },
                        991: {
                        slidesPerView: 2,
                        },
                        767: {
                        slidesPerView: 2,
                        },
                        575: {
                        slidesPerView: 1,
                        },
                    }
                    });

                    var swiper = new Swiper('.search-slider2', {
                        slidesPerView: 3,
                    spaceBetween: 30,
                    loop: false,
                    navigation: {
                        nextEl: '.ruddra-next',
                        prevEl: '.ruddra-prev',
                    },
                    autoplay: {
                        speeds: 1000,
                        delay: 2000,
                    },
                    speed: 1000,
                    breakpoints: {
                        1400: {
                        slidesPerView: 4,
                        },
                        1199: {
                        slidesPerView: 3,
                        },
                        991: {
                        slidesPerView: 2,
                        },
                        767: {
                        slidesPerView: 2,
                        },
                        575: {
                        slidesPerView: 1,
                        },
                    }
                    });

                    // swiper-slide-duplicate
                    //    data.responseJSON['doctors'][0];
                    // data['articles'][0].length;
                    // data['youtube'][0].length;

                    // if(data.responseJSON['doctors'][0].length <= 4){
                    //     document.getElementsByClassName("swiper-slide-duplicate").style.display = "none";
                    // }






                },
                success: function (data) {

                    // var i = 0;
                    var x ="";
                    var y ="";
                    var z ="";
                    document.getElementById("demo").innerHTML = x;
                    document.getElementById("demo1").innerHTML = y;
                    document.getElementById("demo2").innerHTML = z;

                    // console.log(data['doctors'][0]);
                    console.log(data['youtube'][0]);
                    // console.log(data['articles'][0]);

                    // docLen = data['doctors'][0].length;
                    // articlLen = data['articles'][0].length;
                    // lecLen = data['youtube'][0].length;

                    if(data['doctors'][0].length > 0){
                        d0.style.display = "block";
                    }else{
                        d0.style.display = "none";
                    }
                    if(data['youtube'][0].length > 0){
                        d2.style.display = "block";
                    }else{
                        d2.style.display = "none";
                    }
                    if(data['articles'][0].length > 0){
                        d1.style.display = "block";
                    }else{
                        d1.style.display = "none";
                    }

                    if(data['doctors'][0].length === 0 && data['youtube'][0].length === 0 && data['articles'][0].length === 0){
                        document.getElementById("datanot").style.display = "block";
                    }else{
                        document.getElementById("datanot").style.display = "none";
                    }


                    for ( var i in data['doctors'][0]) {
                        // $('#target').append('<div id="r'+ i +'" class="ansbox"></div>');



                                    // x=  x +'<div class="col-xl-6 col-lg-4 col-md-6 mrb-30">'+
                                    //     '<div class="team-item d-flex flex-wrap align-items-center justify-content-between">'+
                                    //         '<div class="team-thumb">'+
                                    //             '<img src="assets/doctor/images/profile/'+ data['doctors'][0][i]['image']+ '" alt="@lang("doctor-image")">'+
                                    //         '</div>'+
                                    //          '<div class="team-content">'+
                                    //                         '<h5 class="title">'+data['doctors'][0][i]['name']+'</h5>'+
                                    //                         '<p>'+data['doctors'][0][i]['about']+'</p>'+
                                    //                         '<h6 class="title">'+'Qualification'+'</h6>'+
                                    //                         '<p>'+data['doctors'][0][i]['qualification']+'</p>'+

                                    //                         '<div class="booking-btn">'+
                                    //                            '<a href="booking/'+data['doctors'][0][i]['id']+'" class="cmn-btn">@lang('Book Now')</a>'+
                                    //                             '</div>'+
                                    //                             '</div>'+
                                    //                             '</div>'+
                                    //                             '</div>'+
                                    //                             '</div>';

                    //     x = x+
                    //     '<div class="swiper-slide">'+
                    //     '<div class="col-md-3 mrb-30 ">'+
                    //     '<div class="card doc-card m-2" >'+
                    //         '   <a href="doctorDetails/'+data['doctors'][0][i]['id']+'" >  <img class="card-img-top doc-card-img" src="assets/doctor/images/profile/'+ data['doctors'][0][i]['image']+ '" alt="@lang("doctor-image")"></a>'+
                    //         '<div class="card-body">'+
                    //           '<p class="card-text text-center line-space-1" style="margin-bottom: 0px;">'+data['doctors'][0][i]['name']+'</p>'+
                    //           '<p class="text-secondary text-center " style="margin-top: 0px; font-size:11px;">'+data['doctors'][0][i]['qualification']+'</p>'+

                    //         '</div>'+
                    //         '<div class="text-center card-footer  booking-btn">'+

                    //             '<a href="doctorDetails/'+data['doctors'][0][i]['id']+'" class="cmn-btn" style="font-size: 13px"> <span><i class="fa fa-book" aria-hidden="true"></i> </span> View</a> '+
                    //             '<a href="booking/'+data['doctors'][0][i]['id']+'" class="cmn-btn" style="font-size: 13px"><span><i class="fa fa-calendar-check" aria-hidden="true"></i> </span> Channel</a>'+


                    //         '</div>'+
                    //     '</div>'+
                    // '</div>'+
                    // '</div>'

                        x = x+

                        '<div class=" swiper-slide" >'+

                            '<div class="card doc-card " >'+
                                '<a  href="doctorDetails/'+data['doctors'][0][i]['id']+'" >  <img class="card-img-top doc-card-img" src="assets/doctor/images/profile/'+ data['doctors'][0][i]['image']+ '"  alt="@lang('doctor-image')" alt="Card image cap"></a>'+

                                '<div class="card-body">'+
                                    '<p class="card-text text-center line-space-1" style="margin-bottom: 0px;">'+data['doctors'][0][i]['name']+'</p>'+
                                    '<p class="text-secondary text-center limitl2" style="margin-top: 0px; font-size:11px;">'+data['doctors'][0][i]['qualification']+'</p>'+
                                '</div>'+
                                '<div class="text-center card-footer booking-btn">'+

                                    '<a href="doctorDetails/'+data['doctors'][0][i]['id']+'" class="cmn-btn" style="font-size: 13px"> <span><i class="fa fa-book" aria-hidden="true"></i> </span> View</a> '+
                                    '<a href="booking/'+data['doctors'][0][i]['id']+'" class="cmn-btn" style="font-size: 13px"><span><i class="fa fa-calendar-check" aria-hidden="true"></i> </span> Channel</a>'+

                                '</div>'+

                            '</div>'+

                        '</div>'

                        // for (i=1; i<=6; i++) {
                        // x = "<h" + i + ">Heading " + i + "</h" + i + ">";
                        // }
                        document.getElementById("demo").innerHTML = x;

                    }

             for ( var j in data['youtube'][0]) {
                            // $('#target').append('<div id="r'+ i +'" class="ansbox"></div>');
                            // alert(data['youtube'][0][j]);

                         // '<p class="limitl3">'+data['youtube'][0][j]['description']+'</p>'+

                            y=  y +
                        '<div class="swiper-slide  ">'+
                            '<div class="booking-item article-card home-lec-h">'+
                                '<div class="booking-thumb text-center">'+
                                    '<iframe height="150" width="100%"  src='+data['youtube'][0][j]['youtube_link']+' title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'+
                                    '<span class="blog-cat">'+data['youtube'][0][j]['name']+'</span>'+
                                '</div>'+

                                '<div class="booking-content text-center">'+
                                    '<h4 class="title limitl3">'+data['youtube'][0][j]['title']+' </a></h4>'+


                            '</div>'+
                            '</div>'+
                        '</div>';

                    document.getElementById("demo2").innerHTML = y;

                        }

                        for ( var k in data['articles'][0]) {
                            // $('#target').append('<div id="r'+ i +'" class="ansbox"></div>');



                            // z=  z +
                        // '<div class="swiper-slide">'+
                        //     '<div class="blog-item article-card">'+
                        //         '<div class="blog-thumb">'+
                        //             '<img src="assets/articles/'+ data['articles'][0][k]['article_image']+ '" alt="@lang("doctor-image")">'+
                        //             '<span class="blog-cat">'+data['articles'][0][k]['name']+'</span>'+
                        //         '</div>'+

                        //         '<div class="blog-content">'+
                        //             '<h4 class="title">'+data['articles'][0][k]['article_title']+' </a></h4>'+
                        //             '<p style=" width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">'+data['articles'][0][k]['article_description']+'</p>'+
                        //             '<div class="blog-btn">'+
                        //     '<a href="/blog/details/'+data['articles'][0][k]['id']+'/'+data['articles'][0][k]['article_title']+'" class="custom-btn">@lang('Continue Reading')</a>'+
                        // '</div>'+

                        //     '</div>'+
                        //     '</div>'+
                        // '</div>';

                        z = z+
                        '<div class="swiper-slide ">'+
                            '<div class="booking-item article-card home-art-h">'+
                                '<div class="booking-thumb text-center">'+
                                    '<img src="assets/articles/'+ data['articles'][0][k]['article_image']+ '"'+
                                       ' alt="@lang("blog-image")">'+
                                       '<br>'+
                                       '<span class="blog-cat">'+data['articles'][0][k]['name']+'</span>'+

                                '</div>'+
                                '<div class="booking-content text-center">'+

                                    '<h5 class="title limitl2">'+data['articles'][0][k]['article_title']+' </h5>'+
                                    '<p class="limitl3">'+data['articles'][0][k]['article_description']+'</p>'+

                                    '<div class="blog-btn">'+
                                       ' <a href="/blog/details/'+data['articles'][0][k]['id']+'/'+data['articles'][0][k]['id']+'"'+
                                            'class="custom-btn">@lang("Continue Reading")</a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'


                    document.getElementById("demo1").innerHTML = z;

                        }

                        }




            });





                    });

        })(jQuery);
    </script>
@endpush


<!-- appoint-section end -->
