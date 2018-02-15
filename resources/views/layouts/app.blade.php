<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      @if(Request::is('parse/*/edit') or Request::is('parse/create'))
      <link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">
      <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
      @endif
      @if(Request::is('parse'))<link href="{{ asset('css/dps_club_scoreboards.css') }}" rel="stylesheet">@endif
      <link rel="icon" href="/favicon.ico" type="image/x-icon" />
   </head>
   <body>
      <div id="app">
         <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                     <span class="sr-only">Toggle Navigation</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>@auth <span class="navbar-user">:{{{Auth::user()->name}}}</span> @endauth
               </div>
               <div class="collapse navbar-collapse" id="app-navbar-collapse">
                  <ul class="nav navbar-nav navbar-right">
                     @guest
                     <li><a href="{{ route('login') }}">Login</a></li>
                     <li><a href="{{ route('register') }}">Register</a></li>
                     @else
                     @role('Admin')
                     <li><a href="/users"><i class="fa fa-btn fa-unlock"></i>Admin</a></li>
                     @endrole
                     <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                     </form></li>
                     @endguest
                  </ul>
               </div>
            </div>
         </nav>
         @if(Session::has('flash_message'))
         <div class="container">
            <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
            </div>
         </div>
         @endif
         {{--
         <div class="row">
            <div class="col-md-8 col-md-offset-2">
               @include ('errors.list')
            </div>
         </div>
         --}}
         @yield('content')
      </div>
      <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
      @if(!Request::is('parse/iframe-scoreboards'))<script src="{{ asset('js/app.js') }}"></script>@endif
      @if(Request::is('start'))<script src="{{ asset('js/bootstrap-confirmation.min.js') }}"></script>@endif
      @if(Request::is('parse/*/edit') or Request::is('parse/create'))
      <script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
      <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
      @endif
      @if(Request::is('parse/*/edit') or Request::is('parse/create'))<script src="{{ asset('js/custom.js') }}"></script>@endif
      @if(Request::is('start'))<script src="{{ asset('js/starting-points.js') }}"></script>@endif
   </body>
</html>