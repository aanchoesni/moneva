<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="PPTI UNESA - INSEO">
    <meta name="keyword" content="Survey UNESA">
    <link rel="shortcut icon" href="img/favicon.html">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap core CSS -->
    {{Html::style("backend/css/bootstrap.css")}}
    {{Html::style("backend/css/bootstrap-reset.css")}}
    <!--external css-->
    {{Html::style("backend/assets/font-awesome/css/font-awesome.css")}}
    <!-- Custom styles for this template -->
    @yield('asset')
    {{Html::style("backend/css/style.css")}}
    {{Html::style("backend/css/style-responsive.css")}}
    {{Html::style("backend/sw/dist/sweetalert.css")}}

  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <header class="header white-bg">
          <div class="sidebar-toggle-box">
              <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
          </div>
          <!--logo start-->
          <a href="url('home')" class="logo" >SIM <span>MONEV</span></a>
          <!--logo end-->
          <div class="top-nav ">
              <ul class="nav pull-right top-menu">
                  <!-- user login dropdown start-->
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          {{-- <img alt="" src="img/avatar1_small.jpg"> --}}
                          <span class="username">{!! Auth::user()->name !!} - {!! Auth::user()->role !!}</span>
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu extended logout">
                          <div class="log-arrow-up"></div>
                          <li></li>
                          <li>
                              <a href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                  Logout
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>
                          </li>
                      </ul>
                  </li>
              </ul>
          </div>
      </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar" class="nav-collapse">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  @if(Auth::user()->role == 'admin')
                    @include('layouts.menuadmin')
                  @endif
                  @if(Auth::user()->role == 'jurusan')
                    @include('layouts.menuadmin')
                  @endif
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              @include('layouts.partials.alert')
              @include('layouts.partials.validation')
              @yield('content')
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2017 &copy; SIM Monev - FMIPA UNESA
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  {{-- <script type="text/javascript" src="{!!asset('backend/assets/advanced-datatable/media/js/jquery.js') !!}"></script> --}}
  @yield('script')
  {{Html::script("backend/js/bootstrap.min.js")}}
  {{Html::script("backend/js/jquery.dcjqaccordion.2.7.js")}}
  {{Html::script("backend/js/jquery.scrollTo.min.js")}}
  {{-- <script type="text/javascript" src="https://statik.unesa.ac.id/survey_konten_statik/backend/js/jquery.nicescroll.js"></script> --}}
  {{Html::script("backend/js/respond.min.js")}}

  <!--common script for all pages-->
  {{Html::script("backend/js/common-scripts.js")}}
  {{Html::script("backend/sw/dist/sweetalert.min.js")}}
  @include('sweet::alert')
  @yield('scriptbottom')
  </body>
</html>
