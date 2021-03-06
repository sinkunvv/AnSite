<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href={{asset('/css/pure-min.css')}} >
        <link rel="stylesheet" href={{asset('/css/style.css')}} >

        <!-- OGP -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="">
        <meta property="og:description" content="">
        <meta property="og:site_name" content="">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

    </head>
    <body>

        <div id="layout">
            <!-- Menu toggle -->
            <a href="#menu" id="menuLink" class="menu-link">
                <!-- Hamburger icon -->
                <span></span>
            </a>

            <div id="menu">
                <div class="pure-menu">
                    <a class="pure-menu-heading" href="/">さくら前線</a>
                    <ul class="pure-menu-list">
                        @section('sidebar')
                        <li class="pure-menu-item">
                            <a href="#new" class="pure-menu-link">新着投稿</a>
                        </li>
                        @show
                    </ul>
                </div>
            </div>
            <div id="main">
               <div class="header">
                   <div class="pure-menu pure-menu-horizontal">
                       <h1>さくら前線</h1>
                       <ul id="rss-link" class="pure-menu-list">
                           <li class="pure-menu-item"><a href="/rss?type=atom" class="pure-menu-link">Atom</a></li>
                           <li class="pure-menu-item"><a href="/rss?type=rss1" class="pure-menu-link">RSS1.0</a></li>
                           <li class="pure-menu-item"><a href="/rss?type=rss2" class="pure-menu-link">RSS2.0</a></li>
                       </ul>
                   </div>

               </div>

               <div class="content">
                   @yield('content')
               </div>
            </div>
        </div>
        <script src="{{asset('/js/ui.js')}} "></script>
    </body>
</html>
