@php
$partner_element = getContent('partner.element', false);
$gallery = \App\Gallery::all();
@endphp
<!-- brand-section start -->
<style>
    .center {
        margin: auto;
        width: 60%;
    }

</style>
<div class="brand-section ptb-80 bgc2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <h2 class="section-title text-center">About Us</h2>
                    <p class="m-0 text-center">We are a leading healthcare provider who strives to give it at
                        world-class quality with the help of eminent professionals and redefined technology. We are
                        prepared to give our patients treatment with homely touch and love at a reasonable bill over
                        everything. </p>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div>
                    <div id="panel-9-11-0-0" class="so-panel widget widget_sow-editor panel-first-child"
                        data-index="27">
                        <iframe height="550" width="100%" src="https://www.youtube.com/embed/UkdTbiW2Tcg"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>


                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div>
                    <p class="m-0"> The recently organized “health educators’ platform” is privileged to launch the very
                        first health educators’ platform (website and YouTube channel) in Sri Lanka. This organization
                        comprises over forty Medical Practitioners in their roles as health educators. Explore health,
                        with due consideration of the priority areas of health, is focused on health education in all 3
                        languages using digital screens and readable materials.
                        <br>
                        <br>
                        The Founder of Explore Health Dr Kaushalya Perera was blessed with more than 40 medical
                        professionals in their role as health educators to launch a roborst educator’s platform on the
                        19th of June in 2020 at the Grand ballroom Galadari. Chair Professor of pharmacology of faculty
                        of medicine at Sri Jayewardenepura University, Professor Chandani Wanigatunge added so much
                        value at the launch as the Chief guest.
                        <br>
                        <br>
                        It is our firm conviction that the explore health will become a great source to cover the
                        knowledge gaps in health since it is a dire need in the country relating both to the
                        communicable and non-communicable diseases that engulf several unsuspecting persons who lack the
                        knowledge to protect themselves
                    </p>
                </div>
            </div>
        </div>
        {{-- galary --}}
        <div class="row ptb-80">
            <div class="col-lg-12 col-md-12">
                <div class="section-header">
                    <h2 class="section-title text-center">Gallery</h2>

                </div>
            </div>
            <div class="col-lg-12 col-md-12">


                <div class="booking-slider">
                    <div class="swiper-wrapper">
                        @foreach ($gallery as $item)
                            <div class="swiper-slide">
                                <div class="gimg">
                                    <img src="{{ asset('/assets/images/gallery/' . $item->image) }}"
                                        alt="@lang('sector')" onclick="on(this)">
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


                {{-- <div class="booking-slider">
                    <div class="swiper-wrapper">
                        @foreach ($gallery as $item)
                        <div class="card gallery-card">

                            <div class="swiper-slide">
                                <div class="card gallery-card">

                                    <img class="gimg"  src="{{ asset('/assets/images/gallery/' . $item->image )}}" alt="@lang('sector')">

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
                </div> --}}
            </div>


        </div>
        {{-- end galary --}}
        <div class="row">
            <div class="client-section bgc2 col-lg-12 col-md-12">
                <div class=" row justify-content-center ml-b-30">

                    <div class="col-xl-3 col-lg-2 col-md-3 mrb-30">
                        <div class="team-item d-flex flex-wrap align-items-center justify-content-between">

                            <div class="text-center center">
                                <i class="fas fa-user-nurse fa-3x"></i>
                                <br />
                                <h4 class="title">39</h4>
                                <h6 class="title">@lang('Doctors')</h6>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-2 col-md-3 mrb-30">
                        <div class="team-item d-flex flex-wrap  justify-content-between">

                            <div class="text-center center">
                                <i class="fas fa-clinic-medical fa-3x"></i>
                                <br />
                                <h4 class="title">39</h4>
                                <h6 class="title">@lang('Clinic Rooms')</h6>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-2 col-md-3 mrb-30">
                        <div class="team-item d-flex flex-wrap  justify-content-between">

                            <div class="text-center center">
                                <i class="fas fa-user-friends fa-3x"></i>
                                <br />
                                <h4 class="title">92</h4>
                                <h6 class="title">@lang('Happy Patients')</h6>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 ">
                        <div class="team-item d-flex flex-wrap  justify-content-between">

                            <div class="text-center center">
                                <i class="fas fa-award fa-3x"></i>
                                <br />
                                <h4 class="title">150</h4>
                                <h6 class="title">@lang('Awards')</h6>

                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>


        <div class="row ptb-80">


            <div class="col-lg-7 col-md-7">
                <div class="row">
                    <div class="col-lg-1 col-md-1 serv-icon">
                        <i class="fas fa-building fa-3x"></i>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <h4>Great Infrastructure</h4>
                        <p>The best in class labs and test equipments providing the best results</p>
                    </div>
                </div>
                <br />
                <br />
                <div class="row">
                    <div class="col-lg-1 col-md-1 serv-icon">
                        <i class="fas fa-heartbeat fa-3x"></i>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <h4>Qualified Doctors</h4>
                        <p>Highly qualified at your service waiting to look to all your needs</p>
                    </div>
                </div>
                <br />
                <br />
                <div class="row">
                    <div class="col-lg-1 col-md-1 serv-icon">
                        <i class="fas fa-shield-alt fa-3x"></i>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <h4>Emergency Support</h4>
                        <p>Providing fast test reports and catering to our patients need</p>
                    </div>
                </div>
                <br />
                <br />
                <div class="row">
                    <div class="col-lg-1 col-md-1 serv-icon">
                        <i class="fas fa-ambulance fa-3x"></i>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <h4> Ambulance Service</h4>
                        <p> Highly equiped ambulance service arriving as soon as possible</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div>
                    <div id="panel-9-11-0-0" class="so-panel widget widget_sow-editor panel-first-child"
                        data-index="27">
                        <img src="{{ asset('/assets/images/features.jpg') }}" height="500"
                            alt="@lang('doctor-image')">
                    </div>


                </div>
            </div>

        </div>

    </div>



    {{-- <div class="container aos-init aos-animate" data-aos="fade-up">

       <h2 class="section-title">About Us</h2>

        <div class="row">
          <div class="col-lg-4 col-md-6 icon-box aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon"><i class="fas fa-tablets fa-3x"></i></div>
            <h4 class="title"><a href="">Medical Health Care</a></h4>
            <p class="description">For all your tests related health needs this is the right place you are looking for,we cater to our patients need with utmost care.</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box aos-init aos-animate" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon"><i class="fas fa-tablets fa-3x"></i></div>
            <h4 class="title"><a href="">Background Checks</a></h4>
            <p class="description">Performing a full background check of our doctors and workers so that our patients don’t face any inconvenience.</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box aos-init aos-animate" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon"><i class="fas fa-tablets fa-3x"></i></div>
            <h4 class="title"><a href="">Special Doctor</a></h4>
            <p >A special doctor who acts as senior overlooker providing extra suggestions to all your cases.</p>
          </div>

        </div>

      </div> --}}

    <br />
    <!--begin container -->
    <div class="container">

        <!--begin row -->
        <div class="row">

            <!--begin col-md-12-->
            <div class="col-md-12 text-center">

                <h2 class="section-title">Our Services</h2>

            </div>
            <br>
            <!--end col-md-12 -->

        </div>
        <!--end row -->

        <!--begin row -->
        <div class="row">

            <!--begin col-md-4 -->
            <div class="col-md-4">

                <div class="main-services text-center">

                    <i class="fas fa-heartbeat fa-3x"></i>
                    <br />
                    <h4>Medical Health Care</h4>

                    <p>For all your tests related health needs this is the right place you are looking for,we cater to
                        our patients need with utmost care.</p>

                </div>

            </div>
            <!--end col-md-4 -->

            <!--begin col-md-4 -->
            <div class="col-md-4">

                <div class="main-services text-center">

                    <i class="fas fa-tablets fa-3x"></i>
                    <br />
                    <h4>Background Checks</h4>

                    <p>Performing a full background check of our doctors and workers so that our patients don’t face any
                        inconvenience.</p>

                </div>

            </div>
            <!--end col-md-4 -->

            <!--begin col-md-4 -->
            <div class="col-md-4">

                <div class="main-services text-center">

                    <i class="fas fa-prescription fa-3x"></i>
                    <br />
                    <h4>Special Doctor</h4>

                    <p>A special doctor who acts as senior overlooker providing extra suggestions to all your cases.</p>

                </div>

            </div>
            <!--end col-md-4 -->

        </div>
        <!--end row -->

    </div>
    <!--end container -->





    {{-- <div class="booking-search-area">
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
    {{-- <button type="submit" class="search-btn cmn-btn"><i class="icon-search"></i></button> --}}
    </form>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- brand-section end -->

<div class="overlay" onclick="off(this)">
    <div class="full-img gimg">
        <img id="full_img" src="" alt="">
    </div>
</div>

<script>
    var on = function(x) {
        console.log("hi");
        var o = document.querySelector(".overlay");
        var i = document.querySelector("#full_img");
        o.style.display = "block";
        i.src = x.src;


    }


    var off = function(x) {
        x.style.display = "none";
    }
</script>
