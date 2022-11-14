<div class="sidebar capsule--rounded bg_img overlay--dark" style="background-color:#000983">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo2.png')}}" alt="@lang('image')"></a>
            <a href="{{route('admin.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>

                {{-- Admin --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.author*',3)}}">
                        <i class="menu-icon fas fa-pen"></i>
                        <span class="menu-title">@lang('Admin')</span>
                      
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.author*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.admin.new')}}">
                                <a href="{{route('admin.admin.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Admin')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.admin.all')}}">
                                <a href="{{route('admin.admin.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Admins')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>

                <!-- <li class="sidebar-menu-item {{menuActive('admin.sector*')}}">
                    <a href="{{route('admin.sector')}}" class="nav-link ">
                        <i class=" menu-icon fas fa-list"></i>
                        <span class="menu-title">@lang('Categories')</span>
                    </a>
                </li> -->

                <!-- <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.coaches*',3)}}">
                        <i class="menu-icon fas fa-book-open"></i>
                        <span class="menu-title">@lang('Library')</span>
                        
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.coaches*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.posts.new')}}">
                                <a href="{{route('admin.posts.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Article')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.posts.all')}}">
                                <a href="{{route('admin.posts.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Articles')</span>
                                </a>
                            </li>

                         


                            

                        </ul>
                    </div>
                </li> -->

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.coaches*',3)}}">
                        <i class="menu-icon fas fa-chalkboard-teacher"></i>
                        <span class="menu-title">@lang('Coaches')</span>
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.coaches*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.coaches.new')}}">
                                <a href="{{route('admin.coaches.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                   
                                    <span class="menu-title">@lang('Add New Coaches')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.coaches.all')}}">
                                <a href="{{route('admin.coaches.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Coaches')</span>
                                </a>
                            </li>
                            <!-- <li class="sidebar-menu-item {{menuActive('admin.availabilityCoach.all')}}">
                                <a href="{{route('admin.availabilityCoach.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Coach Availability')</span>
                                </a>
                            </li> -->

                            

                        </ul>
                    </div>
                </li>

                {{-- Principal --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.principals*',3)}}">
                        <i class="menu-icon fas fa-users"></i>
                        <span class="menu-title">@lang('Customers')</span>
                        
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.principals*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.principals.new')}}">
                                <a href="{{route('admin.principals.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Customers')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.principals.all')}}">
                                <a href="{{route('admin.principals.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Customers')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>

             



                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.coaches*',3)}}">
                        <i class="menu-icon fas fa-file"></i>
                        <span class="menu-title">@lang('Reports')</span>
                       
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.coaches*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.chatReport.all')}}">
                                <a href="{{route('admin.chatReport.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                   
                                    <span class="menu-title">@lang('Chat Reports')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.callReport.all')}}">
                                <a href="{{route('admin.callReport.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Call Reports')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.userReport.all')}}">
                                <a href="{{route('admin.userReport.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('User Reports')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.chats*',3)}}">
                        <i class="menu-icon fas fa-comment"></i>
                        <span class="menu-title">@lang('Chats')</span>
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.chats*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.chats.coaching_question')}}">
                                <a href="{{route('admin.chats.coaching_question')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Coaching Question')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.chats.technical_support')}}">
                                <a href="{{route('admin.chats.technical_support', 'new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Technical Support')</span>
                                </a>
                            </li>
                            {{-- <li class="sidebar-menu-item {{menuActive('admin.chats.leave_feedback')}}">
                                <a href="{{route('admin.chats.leave_feedback')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Leave Feedback')</span>
                                </a>
                            </li> --}}
                            <li class="sidebar-menu-item {{menuActive('admin.chats.other')}}">
                                <a href="{{route('admin.chats.other')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Other Questions')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


          

                <!-- <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.email-template*',3)}}">
                        <i class="menu-icon la la-envelope-o"></i>
                        <span class="menu-title">@lang('Email Manager')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.email-template*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.email-template.global')}} ">
                                <a href="{{route('admin.email-template.global')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Global Template')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive(['admin.email-template.index','admin.email-template.edit'])}} ">
                                <a href="{{ route('admin.email-template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Templates')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.email-template.setting')}} ">
                                <a href="{{route('admin.email-template.setting')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Configure')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>  -->
            </ul>

            {{-- <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{systemDetails()['name']}}</span>
                <span class="text--success">@lang('V'){{systemDetails()['version']}} </span>
            </div> --}}
        </div>
    </div>
</div>
<!-- sidebar end -->
<style type="text/css">
    [class*="overlay"].overlay--dark::before {
        background-color: #000650 !important;
    }
    .sidebar__menu .menu-icon {
        min-width: 25px !important;
    }
</style>