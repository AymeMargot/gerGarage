  <header id="header" class="fixed-top">
    <div class="container d-flex">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="{{ url('/') }}"><span>gerGarage</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>
      <nav class="nav-menu d-none d-lg-block">
        <ul>
          @if (Route::has('login'))
          @auth
          <li class="drop-down"><a href="#">{{ Auth::user()->name }} </a>
            <ul>
              @can('admin')
              <li><a class="dropdown-item" href="{{ url('/accessories') }}">Manage Accessories</a></li>
              <li><a class="dropdown-item" href="{{ url('/supplies') }}">Manage Supplies</a></li>
              <li><a class="dropdown-item" href="{{ url('/makes') }}">Manage Makes</a></li>
              <li><a class="dropdown-item" href="{{ url('/vehicles_parts') }}">Manage Vehicle Parts</a></li>
              <li><a class="dropdown-item" href="{{ url('/messages') }}">Customers Feedback</a></li>
              <hr>
              <li> <a class="dropdown-item" href="{{ url('/bookings') }}">Manage Bookings</a></li>
              <li> <a class="dropdown-item" href="{{ url('/invoices') }}">Manage Invoices</a></li>
              <hr>
              <li> <a class="dropdown-item" href="{{ url('/rosters') }}">Manage Roster</a></li>
              <li><a class="dropdown-item" href="{{ url('/staff') }}">Manage Staff</a></li>
              @endcan
              @can('mechanic' || 'admin' )              
              <li><a href="{{ url('/rosters/show') }}">My Roster</a></li>
              @endcan
              <hr>
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">{{ __('Logout') }} {{ Auth::user()->gotRole()}}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
          @else
          <li><a href="{{ route('login') }}">Login</a></li>
          @if (Route::has('register'))
          <li><a href="{{ route('register') }}">Register</a></li>
          @endif
          @endauth
          @endif          
       <!--   <li class="active"><a href="/loadData">load</a></li> -->
                 
          <li class="active"><a href="/home">Home</a></li>
          <li><a href="/services">Services</a></li>
          <li><a href="/listAccessories">Accesories</a></li>
          <li><a href="/listSupplies">Vehicle Supplies</a></li>
          <li><a href="/listVehicleparts">Vehicle Parts</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <div class="header-social-links">
        <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
      </div>

    </div>
  </header>