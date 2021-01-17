<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{url('admin/dashboard')}}">
       {{-- <img src="{{asset('images/logo_2.png')}}" alt="logo" /> --}}
        <h2 style="color:#f9d100">Tod-Z</h2>
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{url('admin/dashboard')}}">
         {{-- <img src="{{asset('images/logo_1.png')}}" alt="logo" /> --}}
       <h2 style="color:#f9d100">TZ</h2>
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
         <!-- <ul class="navbar-nav">
          <li class="nav-item dropdown d-none d-lg-flex">
            <a class="nav-link dropdown-toggle nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
              <span class="btn">+ Create new</span>
            </a>
            <div class="dropdown-menu navbar-dropdown dropdown-left" aria-labelledby="actionDropdown">
              <a class="dropdown-item" href="#">
                <i class="icon-user text-primary"></i>
                User Account
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i class="icon-user-following text-warning"></i>
                Admin User
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i class="icon-docs text-success"></i>
                Sales report
              </a>
            </div>
          </li>
        </ul>  -->
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-block">
                <a href="javascript:;" class="nav-item ">
                    <span>@yield('user_name')</span>
                </a>
            </li>

            <li class="nav-item d-none d-lg-block" style="position: relative;">
                <a class="nav-link Notificationtogglebtn" href="javascript:;">
                    <img src="{{asset('web/images/ic_notification_bell.png')}}">
                </a>
                <span class="badge badge-pill badge-warning" style="position:absolute;top:0px;right:-5px;background-color: #1e1c15;">
                    {{NotificationManager::notificationCount()}}
                </span>
            </li>
            <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="{{url('admin/logout')}}" style="transform: rotate(180deg)">
                    <i class="icon-logout" ></i>
                </a>
            </li>

        </ul>
        <div class="notificationDiv">
            <ul>
                @if(NotificationManager::notificationCount()>0)
                    @if(!NotificationManager::get()->isEmpty())
                        @foreach( NotificationManager::get() as $notification)
                            <li>
                                <a href="{{url($notification->route_link)}}">{{$notification->message}}</a>
                                <span>{{NotificationManager::getAgoTime($notification->created_at)}}</span>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{url('admin/notifications')}}" class="viewAllBtn">view all</a>
                        </li>
                    @endif
                @else 
                    <li>
                        <a href="javascript:void(0)" style="text-decoration: none;">No Notification</a>
                    </li>
                @endif
            </ul>
        </div>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>