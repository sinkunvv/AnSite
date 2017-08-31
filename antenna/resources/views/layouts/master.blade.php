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
        <!--<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous"> -->
        <link rel="stylesheet" href={{asset('/css/pure-min.css')}} >
        <link rel="stylesheet" href={{asset('/css/side-menu.css')}} >

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
                    <a class="pure-menu-heading" href="#">アンテナサイト</a>

                    <ul class="pure-menu-list">
                        <li class="pure-menu-item"><a href="#" class="pure-menu-link">新着記事</a></li>
                        <li class="pure-menu-item"><a href="#" class="pure-menu-link">表示上位</a></li>
                        <li class="pure-menu-item" class="menu-item-divided pure-menu-selected">
                            <a href="#" class="pure-menu-link">Services</a>
                        </li>
                        <li class="pure-menu-item"><a href="#" class="pure-menu-link">問合せ</a></li>
                    </ul>
                </div>
            </div>
            <div class="wrapper">
                <header>
                    <h1>サイトネーム</h1>
                </header>
                @section('sidebar')

                @show
                <div class="container">
                    @yield('content')
                </div><!-- End container -->
            </div><!-- End wrapper -->
        </div>
        <script src={{asset('/js/ui.js')}}></script>
    </body>
</html>
