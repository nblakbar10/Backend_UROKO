<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top ">
      <a class="bg-light m-4 rounded sidebar-brand brand-logo" href="{{route('dashboard.index')}}"><img src="{{asset('logo/logo1.png')}}" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini" href="{{route('dashboard.index')}}"><img src="{{asset('logo/favicon.png')}}" alt="logo" /></a>
    </div>
    <ul class="nav">
      <li class="nav-item nav-category">
        <span class="nav-link">Navigation</span>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{route('dashboard.index')}}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{route('merchant.index')}}">
          <span class="menu-icon">
            <i class="mdi mdi-home-variant"></i>
          </span>
          <span class="menu-title">Merchant</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#pet-drop" aria-expanded="false" aria-controls="pet-drop">
          <span class="menu-icon">
            <i class="mdi mdi-cat"></i>
          </span>
          <span class="menu-title">Pet</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="pet-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('pet-profile.index')}}">Pet Profile</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('pet-activity.index')}}">Pet Activies</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('pet-activity.index')}}">Pet Gallery</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#adoption-drop" aria-expanded="false" aria-controls="adoption-drop">
          <span class="menu-icon">
            <i class="mdi mdi-format-list-bulleted-type"></i>
          </span>
          <span class="menu-title">Adoption</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="adoption-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('adoption-item.index')}}">Adoption Item</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('adoption-order.index')}}">Adoption Order</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#auction-drop" aria-expanded="false" aria-controls="auction-drop">
          <span class="menu-icon">
            <i class="mdi mdi-format-list-bulleted-type"></i>
          </span>
          <span class="menu-title">Auction</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auction-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('auction-item.index')}}">Auction Item</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('auction-order.index')}}">Auction Order</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#rent-drop" aria-expanded="false" aria-controls="rent-drop">
          <span class="menu-icon">
            <i class="mdi mdi-format-list-bulleted-type"></i>
          </span>
          <span class="menu-title">Rent</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="rent-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('rent-item.index')}}">Rent Item</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('rent-order.index')}}">Rent Order</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{route('pet-hotel-provider.index')}}">
          <span class="menu-icon">
            <i class="mdi mdi-home-variant"></i>
          </span>
          <span class="menu-title">Pet Hotel Provider</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="">
          <span class="menu-icon">
            <i class="mdi mdi-home-variant"></i>
          </span>
          <span class="menu-title">Pet Hotel Order</span>
        </a>
      </li>
      {{-- <li class="nav-item menu-items">
        <a class="nav-link" href="">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Transaksi</span>
        </a>
      </li> --}}
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{route('user.index')}}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">User</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{route('admin.index')}}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Admin</span>
        </a>
      </li>
      {{-- <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
          </span>
          <span class="menu-title">Basic UI Elements</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="pages/forms/basic_elements.html">
          <span class="menu-icon">
            <i class="mdi mdi-playlist-play"></i>
          </span>
          <span class="menu-title">Form Elements</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="pages/tables/basic-table.html">
          <span class="menu-icon">
            <i class="mdi mdi-table-large"></i>
          </span>
          <span class="menu-title">Tables</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="pages/charts/chartjs.html">
          <span class="menu-icon">
            <i class="mdi mdi-chart-bar"></i>
          </span>
          <span class="menu-title">Charts</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="pages/icons/mdi.html">
          <span class="menu-icon">
            <i class="mdi mdi-contacts"></i>
          </span>
          <span class="menu-title">Icons</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <span class="menu-icon">
            <i class="mdi mdi-security"></i>
          </span>
          <span class="menu-title">User Pages</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="http://www.bootstrapdash.com/demo/corona-free/jquery/documentation/documentation.html">
          <span class="menu-icon">
            <i class="mdi mdi-file-document-box"></i>
          </span>
          <span class="menu-title">Documentation</span>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- partial -->