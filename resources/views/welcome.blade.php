<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ url('css/front.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                      @if (Auth::user()->is_admin)
                        <a href="{{ url('admin') }}">Admin</a>
                      @else
                        <a href="{{ url('tickets') }}">My Tickets</a>
                        <a href="{{ url('tickets/new') }}">Open Ticket</a>
                      @endif
                    @else
                        <a href="{{ url('login') }}">Login</a>
                        <a href="{{ url('register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{ config('app.name') }}
                </div>

                <div class="links">
                  @if (Auth::check())
                    @if (Auth::user()->is_admin)
                      <a href="{{ url('admin') }}">Admin Panel</a>
                      <a href="{{ url('admin/tickets') }}">Tickets</a>
                      <a href="{{ url('admin/categories') }}">Categories</a>
                    @else
                      <a href="{{ url('tickets')}}">My Tickets</a>
                      <a href="{{ url('tickets/new') }}">Open Ticket</a>
                    @endif
                      <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                  @else
                    <a href="{{ url('login') }}">Login</a>
                    <a href="{{ url('register') }}">Register</a>
                  @endif
                </div>
            </div>
        </div>
    </body>
</html>
