<!-- Header -->
<header class="absolute-top new-hompage-header  {{ (request()->is('/')) ? '': 'inner' }}">
  <nav class="navbar navbar-expand-lg navbar-light container">
    {{-- @if (Gate::allows('create-project')) 
  <a class="navbar-brand" href="{{route('client_dashboard')}}"><img src="{{asset('web/images/logo.png')}}"></a>
  @elseif (Auth::check()) 
  <a class="navbar-brand" href="{{route('talent_dashboard')}}"><img src="{{asset('web/images/logo.png')}}"></a>
  @else --}}
  <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('web/images/logo.png')}}"></a>
  {{-- @endif --}}

    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
      <ul class="navbar-nav mr-auto ml-3">
        <li>
          <div class="search-box white-place">
            <input class="" type="" name="" placeholder="Search">
            <img src="{{asset('web/images/ic_search_24px.png')}}">
          </div>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item menu-head">
        <a class="nav-link" href="{{route('categories')}}">{{__('messages.nav.CATEGORIES')}}</a>
          <div class="sub-menu pt-2">
            <ul class="list-inline brdr-1 wd-50 mb-0">
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.ADVERTISING')}}</a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.MEDIA')}}</a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.CIA')}}  </a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.HWB')}}</a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.PM')}}</a></li>
            </ul>
            <ul class="list-inline wd-50  mb-0">
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.RA')}}</a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.CW')}}</a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.LEGAL')}}</a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.BD')}}</a></li>
            <li class="full-width"><a href="{{route('categories')}}">{{__('messages.nav.cat.VA')}}</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item menu-head">
            <a class="nav-link" href="{{url('why-work-with-us')}}">{{__('messages.nav.WWWU')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('our-process')}}">{{__('messages.nav.OB')}}</a>
        </li>
        
     

        @if (Gate::allows('create-project')) 
          <li class="nav-item">
            <a class="nav-link" href="{{route('project.create')}}">
                <button type="button" class="create-btn">create a project</button>
            </a>
        </li>
     
          @endif
        @if (!Auth::check()) 
        <li class="nav-item">
          <div class="dropdown sign-up">
          <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">{{__('messages.nav.SIGNUP')}}</a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" href="#">{{__('messages.nav.TODDER')}}</a>
            <hr class="mt-0 mb-0">
            {{-- data-toggle="modal" data-targest="#exampleModal" --}}
          <a class="dropdown-item pt-1" data-toggle="modal" data-target="#signupModal">{{__('messages.nav.PO')}}</a>
          </div>
        </div>
        </li>
        <li class="nav-item">

          <div class="dropdown sign-up">
            <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><button class="header-btn bordered">{{__('messages.nav.LOGIN')}}</button></a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{route('talent_login')}}">{{__('messages.nav.TODDER')}}</a>
              <hr class="mt-0 mb-0">
              {{-- data-toggle="modal" data-targest="#exampleModal" --}}
              <a class="dropdown-item" href="{{route('login.index')}}">{{__('messages.nav.PO')}}</a>
            </div>
          </div>
          

       
        </li>
        @else
        <li class="nav-item" style="position:relative;">
          <a class="nav-link togglebtn" href="#">
              <img src="{{asset('web/images/ic_notification_bell.png')}}" alt="">
             
          </a>
          @if(NotificationManager::notificationCount()>0)
        <span class="badge badge-pill badge-warning" style="position:absolute;top:0;right:0;background-color: #f9d100;">{{NotificationManager::notificationCount()}}</span>
        @endif
      </li>
      <li class="nav-item">
      
            @if(!is_null(Auth::user()->user_image) && !empty(Auth::user()->user_image))
            <a class="nav-link toggleDiv" href="#">
            <img src="{{asset(Auth::user()->user_image)}}" alt=""class="profileImg">
          </a>
            @else
            <a class="nav-link toggleDiv" href="#">
          <div class="second_letter" ><span >{{substr(Auth::user()->first_name,0,1)}}</span></div>
            </div>
          </a>
          @endif
            
         
        </li>

        <div class="profileDiv">
          <ul>
            @if(auth()->guard('admin')->check())
                <li>
                    <a href="{{url('admin/dashboard')}}">Dashboard</a>
                </li>
            @else
                <li>
                    <a href="{{auth()->user()->role==config('constants.role.TALENT')?url('talent/dashboard'):url('client/dashboard')}}">Dashboard</a>
                </li>
               
                <li>
                  <a href="{{auth()->user()->role==config('constants.role.TALENT')?url('talent/profile'):url('client/profile')}}">My Profile</a>
                </li>
                <li>
                  <a href="#" id="deactivateAc">De-activate Ac</a>
                </li>
            @endif   
                <li>
                    <a href="{{url('logout')}}">Log Out</a>
                </li>
            </ul>
        </div>
     
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
                    @endif
                @else 
                <li>
                    <a href="javascript:void(0)">No Notification</a>
                </li>
                @endif
                <li>
                    <a href="{{route('notifications.index')}}" class="viewAllBtn">view all</a>
                </li>
            </ul>
        </div>
     
      @endif
     
      </ul>
  </div>
</nav>
</header>

<!-- exampleModal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document" style="max-width: 380px;">
  <div class="modal-content">
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <a href="{{route('li_redirect',['type'=>'1'])}}"><button class="linkedIn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_linkedin.png')}}">Linkedin</button></a>
        </div>
        <div class="col-md-12">
          <a href="{{route('fb_redirect',['type'=>'1'])}}"><button class="facebook-btn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_facebook.png')}}">Facebook</button></a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form method="get" action="{{url('signup')}}">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="entity" id="Radios1" value="{{config('constants.entity.CORPORATE')}}" checked>
            <label class="form-check-label" for="Radios1">
              <span>
                <img src="{{asset('web/images/corporate_entity.png')}}" alt="">
                <h2>{{__('messages.corporate_entity')}}</h2>
                <p>{{__('messages.corporate_entity_text')}}</p>
              </span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="entity" id="Radios2" value="{{config('constants.entity.PRIVATE')}}" >
            <label class="form-check-label" for="Radios2">
              <span>
                <img src="{{asset('web/images/private_entity.png')}}" alt="">
                <h2>{{__('messages.private_entity')}}</h2>
                <p>{{__('messages.private_entity_text')}}</p>
              </span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="entity" id="Radios3" value="{{config('constants.entity.INDIVIDUAL')}}">
            <label class="form-check-label" for="Radios3">
              <span>
                <img src="{{asset('web/images/individual.png')}}" alt="">
                <h2>{{__('messages.individual_entity')}}</h2>
                <p>{{__('messages.individual_entity_text')}}</p>
              </span>
            </label>
          </div>
          <button class="theme-button hover-ripple text-upper" style="width: 100%;">continue</button>
        </form>
        </div>
      </div>
    </div>
  </div>

