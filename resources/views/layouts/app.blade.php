<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{Html::style('css/style.css')}}

    <!-- Scripts -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    {{-- <script src="{{ url('js/app.js') }}"></script> --}}


    <style>
        .links{
            padding: 0px,20px;
            color: white;
        }
    </style>



</head>

<body>
    <div id="app">
        <div class="">
            <div class="mail-box">
                <aside class="sm-side">
                    <div class="user-head">
                        <a class="inbox-avatar" href="{{ url('images/users/hoor.jpg') }}">
                            <img width="64" hieght="60"
                                src="{{ url('images/users/hoor.jpg') }}"  style="height: 70px;">
                        </a>
                        @if(Auth::check())
                            <div class="user-name">
                                <h5><a href="#">{{ Auth::user()->name }}</a></h5>
                                <span><a href="#">{{ Auth::user()->email }}</a></span>
                                <span>
                                    <i class="fa fa-lock"></i>
                                    <a href="{{ route('logout') }}">LOG OUT</a>
                                </span>
                            </div>
                        @endif
                        <a class="mail-dropdown pull-right" href="javascript:;">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>

                    <users-list></users-list>
                    
                    


                </aside>
                <aside class="lg-side">
                    <div class="inbox-head">
                        <h3>Real Time Chat</h3>
                        <ul class="inbox-nav inbox-divider">                        
                            <a
                             class="links">
                                <router-link to="/add"><i class="fa fa-inbox"></i> Add Room </router-link>
                            </a>
                            <a class="links">
                                <router-link to="/my"><i class="fa fa-inbox"></i> My Rooms </router-link>
                            </a>
                            <a class="links">
                                <router-link to="/all"><i class="fa fa-inbox"></i> All Rooms </router-link>
                            </a>

                        </ul>
                    </div>
                    <div class="inbox-body">
                        @yield('content')
                    </div>
                </aside>
            </div>
        </div>

    </div>
    {{Html::script('js/app.js')}}
</body>

</html>
