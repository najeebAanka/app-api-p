<!-- Page Sidebar Start-->
        <header class="main-nav">
          <div class="sidebar-user text-center"><a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i>
              </a><img class="img-90 rounded-circle" src="{{url('dashboard/assets')}}/images/dashboard/1.png" alt="">
            <div class="badge-bottom"><span class="badge badge-primary">New</span></div><a href="user-profile.html">
              <h6 class="mt-3 f-14 f-w-600">{{Auth::user()->name}}</h6></a>
            <p class="mb-0 font-roboto">{{Auth::user()->email}}</p>
          
          </div>
          <nav>
            <div class="main-navbar">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="mainnav">           
                <ul class="nav-menu custom-scrollbar">
                  <li class="back-btn">
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
               
                  <li><a class="nav-link menu-title link-nav btn-block btn btn-outline-primary mb-2" 
                       href="{{url('admin/home')}}"><span>Home</span></a></li>
                  <li><a class="nav-link menu-title link-nav btn-block btn btn-outline-primary mb-2" href="{{url('admin/booking-requests')}}"><span>Requests</span></a></li>
              
                  <li><a class="nav-link menu-title link-nav btn-block btn btn-outline-primary mb-2" href="{{url('admin/categories')}}"><span>Categories</span></a></li>
                  <li><a class="nav-link menu-title link-nav btn-block btn btn-outline-primary mb-2" href="{{url('admin/professionals')}}"><span>Professionals</span></a></li>
                  <li><a class="nav-link menu-title link-nav btn-block btn btn-outline-primary mb-2" href="{{url('admin/users')}}"><span>Clients</span></a></li>
              
               
<!--                  <li><a class="nav-link menu-title link-nav" href="support-ticket.html"><i data-feather="headphones"></i><span>Support Ticket</span></a></li>-->
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </header>
        <!-- Page Sidebar Ends-->
        
        
       