<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link rel="icon" href="/favicon.ico" type="image/x-icon" />
      <link rel="author" href="humans.txt" />
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
                  <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>@auth <div class="navbar-user">{{{Auth::user()->name}}}</div> @endauth
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
         @yield('content')
      </div>
      <script src="{{ asset('js/app.js') }}"></script>
      @hasanyrole('Admin|Editor|Viewer')
      @if(Request::is('list'))
      <script src="{{ asset('js/jquery-sortable.js') }}"></script>      
      <script src="{{ asset('js/sortable-lists.js') }}"></script>      
      @endif
      @endhasanyrole
   </body>
</html>