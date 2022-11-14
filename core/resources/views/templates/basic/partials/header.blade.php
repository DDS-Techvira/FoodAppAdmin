<!-- header-section start -->
<header class="header-section header-section-two">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container-fluid">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0" >
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('site-logo')"></a>
                        <div class="language-select d-block d-lg-none ml-auto">
                            <select class="nice-select langSel language-select">
                                @foreach($language as $item)
                                    <option value="{{ __($item->code) }}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ml-auto mr-auto">
                                <li class="{{menuActive('home')}}"><a href="{{ route('home') }}">@lang('Home')</a></li>
                                <li class="{{menuActive('doctors.all')}}"><a href="{{ route('doctors.all') }}">@lang('Doctors')</a></li>
                                <li class="{{menuActive('articles.all')}}"><a href="{{ route('articles.all') }}">@lang('Artcles')</a></li>
                                <li class="{{menuActive('lectures.all')}}"><a href="{{ route('lectures.all') }}">@lang('Lectures')</a></li>
                                @foreach($pages as $k => $data)
                                    <li class=" @if(url()->current() == route('pages',[$data->slug])) active @endif">
                                        <a href="{{route('pages',[$data->slug])}}">{{trans($data->name)}}</a>
                                    </li>
                                @endforeach
                                {{-- <li class="{{menuActive('blog')}}"><a href="{{ route('blog') }}">@lang('Blog')</a></li> --}}
                                <li class="{{menuActive('diseases')}}"><a href="{{ route('diseases') }}">@lang('Diseases')</a></li>
                                <li class="{{menuActive('contact')}}"><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                            </ul>
                            <div class="language-select d-none d-lg-block">
                                <select class="nice-select langSel language-select">
                                    @foreach($language as $item)
                                        <option value="{{ __($item->code) }}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if (Auth::guard('patient')->user()==null)
                                <div class="header-bottom-action">
                                    <a href="{{ route('patient.register') }}" class="cmn-btn"  >@lang('Patient Register')</a>
                                </div>
                                <div class="header-bottom-action">
                                    <a href="{{ route('login') }}" class="cmn-btn" >@lang('Login Now')</a>
                                </div>
                            @else
                                <div class="row">
                                <div class="header-bottom-action">
                                    <a href="{{ route('doctors.all') }}" class="cmn-btn" style="background-color: #4078bd">@lang('Book Now')</a>
                                </div>
                                {{-- <a href="{{ route('patient.logout') }}">Logout</a> --}}
                                <div class="header-bottom-action">
                                    <button class="cmn-btn" style="background-color:green;" type="button" class="" data-toggle="dropdown" data-display="static" aria-haspopup="true"
                                                        aria-expanded="false">
                                        <!-- <span class="navbar-user"> -->
                                            {{-- <span class="navbar-user__thumb"><img
                                                    src="{{ getImage(imagePath()['staff']['path'].'/'. auth()->guard('patient')->user()->image,imagePath()['staff']['size']) }}"
                                                    alt="@lang('image')"></span> --}}

                                            <!-- <span class="navbar-user__info"> -->
                                            {{auth()->guard('patient')->user()->name}}
                                                <!-- <span class="navbar-user__name">{{auth()->guard('patient')->user()->name}}</span> -->
                                                <i class="las la-chevron-circle-down"></i>
                                            <!-- </span> -->

                                        <!-- </span> -->
                                    </button>
                                    <div class="navbar__right">
                                        <ul class="navbar__action-list">
                                            <li class="dropdown">
                                                <div class="dropdown-menu dropdown-menu--sm p-0 border-0 box--shadow1 dropdown-menu-right">
                                                    @if(Route::has('patient.dashboard'))
                                                        <a href="{{ route('patient.dashboard') }}"
                                                            class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                            <i class="dropdown-menu__icon las la-user-circle"></i>
                                                            <span class="dropdown-menu__caption">@lang('Dashboard')</span>
                                                        </a>
                                                    @endif
                                                    @if(Route::has('purchasehistory'))
                                                        <a href="{{ route('purchasehistory') }}"
                                                        class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                            <i class="dropdown-menu__icon las la-shopping-cart"></i>
                                                            <span class="dropdown-menu__caption">@lang('Purchase History')</span>
                                                        </a>
                                                    @endif
                                                    @if(Route::has('patient.profile'))
                                                        <a href="{{ route('patient.profile') }}"
                                                        class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                            <i class="dropdown-menu__icon las la-user-circle"></i>
                                                            <span class="dropdown-menu__caption">@lang('Profile')</span>
                                                        </a>
                                                    @endif
                                                    @if(Route::has('patient.profile'))
                                                        <a href="{{route('patient.password')}}"
                                                        class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                            <i class="dropdown-menu__icon las la-key"></i>
                                                            <span class="dropdown-menu__caption">@lang('Password')</span>
                                                        </a>
                                                    @endif
                                                    @if(Route::has('patient.logout'))
                                                        <a href="{{ route('patient.logout') }}"
                                                        class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                            <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                                                            <span class="dropdown-menu__caption">@lang('Logout')</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                </div>
                            @endif

                            {{-- <div class="header-bottom-action">
                                <a href="{{ route('doctors.all') }}" class="cmn-btn">@lang('Book Now')</a>
                            </div>

                            <div class="header-bottom-action">
                                <a href="{{ route('login') }}" class="cmn-btn">@lang('Login Now')</a>
                            </div> --}}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-section end -->
